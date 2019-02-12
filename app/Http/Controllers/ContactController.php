<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Alias;
use App\Contact;
use App\Email;
use App\Number;
use App\Social;
use App\Network;

use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{

    public function display($id = null){

        $displayContact = $this->getContact($id);

        $contacts = Contact::where('active', 1)
                            ->orderBy('name', 'ASC')
                            ->get();

        foreach($contacts as $contact){
            $contact->full_name = $this->getFullName($contact->name, $contact->lastname);
        }

        return view('contacts/index', compact('contacts', 'displayContact'));
        
    }

    public function getContact($id){

        try{

            if($id == null){

                $contact = Contact::orderBy('name', 'ASC')->firstOrFail();

            }else{

                $contact = Contact::findOrFail($id);

            }
        
        }catch(ModelNotFoundException $e){

            return null;

        }

        $contact->full_name = $this->getFullName($contact->name, $contact->lastname);
        $contact->photo = $contact->photo ?? 'contact.jpg';

        return $contact;
        
    }

    public function getFullName($name, $lastname){

        return $lastname !== null ? $name.' '.$lastname : $name;

    }

    public function getSocialNetworks(){

        $networks = Network::where('id', '!=', '999')->orderByRaw('CASE WHEN name regexp "^[a-zA-Z]" THEN 1 ELSE 2 END ASC, name ASC')->get();
        $custom = ['id' => 999, 'name' => 'custom'];

        return compact('networks', 'custom');

    }

    public function addForm(){
        
        return view('contacts/add', $this->getSocialNetworks());

    }

    public function add(Request $request){

        $this->validateContact($request);

        $validatedData = $request->post();

        $photo_path = $request->file('photo') ? $request->file('photo')->path() : NULL;

        $full_name = $this->getFullName($validatedData['name'], $validatedData['lastname']);

        if($id_contact = $this->create($validatedData)){

            if(!empty($photo_path) && !isset($validatedData['no-photo'])){

                $photo_name = $this->uploadPhoto($photo_path, $id_contact);

                Contact::find($id_contact)->update(['photo' => $photo_name]);
                
            }

            $this->handleAliases($id_contact, $validatedData);

            $this->handleEmails($id_contact, $validatedData);

            $this->handleNumbers($id_contact, $validatedData);

            $this->handleSocialNetworks($id_contact, $validatedData);

            $message = ['message_type' => 'success', 'message' => '<a href="'.url('contacts/'.$id_contact).'" class="msg-link">'.$full_name.'</a> was added to your contacts.'];

        }else{

            $message = ['message_type' => 'error', 'message' => 'There was a problem adding '.$full_name];

        }

        return Redirect::to('contacts/add')->with($message);

    }

    public function validateContact($data){

        $data->validate([
                    'name' => 'required|max:50',
                    'lastname' => 'max:50',
                    'photo' => 'mimes:jpeg,png,gif,bmp|max:10000',
                    'birthday' => 'nullable|date_format:Y-m-d|before_or_equal:today',
                    'address' => 'max:50',
                    'notes' => 'max:1000',
                    'met' => 'nullable|date_format:Y|after_or_equal:1000',
                    'alias' => 'array',
                    'alias.*' => 'max:50',
                    'email' => 'array',
                    'email.*' => 'max:80',
                    'number' => 'array',
                    'number.*' => 'max:50',
                    'username' => 'array',
                    'username.*' => 'max:80',
                ]);

    }

    public function create($data){

        $contact = Contact::create([
                        'name' => $data['name'],
                        'lastname' => $data['lastname'],
                        'birthday' => $data['birthday'],
                        'address' => $data['address'],
                        'notes' => $data['notes'],
                        'met' => $data['met']
                    ]);

        return $contact->id;

    }

    public function uploadPhoto($photo, $id_contact){

        list($width, $height, $format) = getimagesize($photo);

        $photo_name = ($id_contact + 1000).'_'.sha1(date('YmdHis')).'.jpg';

        switch($format){
            case IMAGETYPE_JPEG:
                $exif = exif_read_data($photo);
                $original = imagecreatefromjpeg($photo);
                break;
            case IMAGETYPE_PNG:
                $original = imagecreatefrompng($photo);
                break;
        }

        if($width > 1600 || $height > 1600){

            $original_proportion = $width / $height;

            if($width > $height){

                $new_width = 1600;
                $new_height = (int) (1600 / $original_proportion);

            }else{

                $new_height = 1600;
                $new_width = (int) (1600 * $original_proportion);

            }

            $resized_photo = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($resized_photo, $original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            if(!empty($exif['Orientation'])) {

                switch($exif['Orientation']) {
                    case 3:
                        $resized_photo = imagerotate($resized_photo, 180, 0);
                        break;
                    case 6:
                        $resized_photo = imagerotate($resized_photo, -90, 0);
                        break;
                    case 8:
                        $resized_photo = imagerotate($resized_photo, 90, 0);
                        break;
                }

            }

            imagejpeg($resized_photo, public_path().'/img/contacts/'.$photo_name, 100);
            imagedestroy($resized_photo);
            
        }else{

            move_uploaded_file($photo, public_path().'/img/contacts/'.$photo_name);

        }

        imagedestroy($original);
        
        return $photo_name;

    }

    public function editForm($id){

        $contact = $this->getContact($id);

        $networks = $this->getSocialNetworks();

        return view('contacts/edit', array_merge(compact('contact'), $networks));

    }

    public function edit($id_contact, Request $request){

        $this->validateContact($request);

        $validatedData = $request->post();

        $photo_path = $request->file('photo') ? $request->file('photo')->path() : NULL;

        $full_name = $this->getFullName($validatedData['name'], $validatedData['lastname']);

        if($this->update($id_contact, $validatedData)){

            if(!empty($photo_path) && !isset($validatedData['no-photo'])){

                $photo_name = $this->uploadPhoto($photo_path, $id_contact);

                Contact::find($id_contact)->update(['photo' => $photo_name]);

            }elseif(isset($validatedData['no-photo'])){

                $this->deletePhoto($id_contact);

            }

            $this->handleAliases($id_contact, $validatedData);

            $this->handleEmails($id_contact, $validatedData);

            $this->handleNumbers($id_contact, $validatedData);

            $this->handleSocialNetworks($id_contact, $validatedData);

            $message = ['message_type' => 'success', 'message' => '<a href="'.url('contacts/'.$id_contact).'" class="msg-link">'.$full_name.'</a> was updated.'];

        }else{

            $message = ['message_type' => 'error', 'message' => 'There was a problem updating '.$full_name];

        }

        return Redirect::to('contacts/'.$id_contact.'/edit')->with($message);

    }

    public function update($id_contact, $data){

        return Contact::where('id', $id_contact)
                            ->where('active', 1)
                            ->update([
                                'name' => $data['name'],
                                'lastname' => $data['lastname'],
                                'birthday' => $data['birthday'],
                                'address' => $data['address'],
                                'notes' => $data['notes'],
                                'met' => $data['met']
                            ]);

    }

    public function deletePhoto($id_contact){

        return Contact::where('id', $id_contact)
                            ->update(['photo' => NULL]);

    }

    public function getCustomTag($element_type, $custom_tag, $value){

        if($element_type == $value && empty($custom_tag)){
            return 'Other';
        }elseif($element_type != $value){
            return NULL;
        }else{
            return $custom_tag;
        }

    }

    public function handleAliases($id_contact, $data){

        $aliases = $data['alias'];
        $id_aliases = !empty($data['id_alias']) ? $data['id_alias'] : null;

        for($i = 0; $i < count($aliases); $i++){

            if(!empty($aliases[$i]) && !empty($id_aliases[$i])){

                Alias::where('id', $id_aliases[$i])->where('id_contact', $id_contact)->update(['alias' => $aliases[$i]]);

            }elseif(!empty($aliases[$i]) && empty($id_aliases[$i])){

                Alias::insert(['id_contact' => $id_contact, 'alias' => $aliases[$i]]);

            }else{

                Alias::where('id', $id_aliases[$i])->where('id_contact', $id_contact)->delete();

            }

        }

    }

    public function handleEmails($id_contact, $data){

        $emails = $data['email'];
        $id_emails = !empty($data['id_email']) ? $data['id_email'] : null;
        $type = $data['email_type'];
        $custom_tags = $data['email_custom'];

        for($i = 0; $i < count($emails); $i++){

            $custom_tag = $this->getCustomTag($type[$i], $custom_tags[$i], 5);

            if(!empty($emails[$i]) && !empty($id_emails[$i])){

                Email::where('id', $id_emails[$i])->where('id_contact', $id_contact)->update(['email' => $emails[$i], 'id_type' => $type[$i], 'custom_tag' => $custom_tag]);

            }elseif(!empty($emails[$i]) && empty($id_emails[$i])){

                Email::insert(['id_contact' => $id_contact, 'email' => $emails[$i], 'id_type' => $type[$i], 'custom_tag' => $custom_tag]);

            }else{

                Email::where('id', $id_emails[$i])->where('id_contact', $id_contact)->delete();

            }

        }

    }

    public function handleNumbers($id_contact, $data){

        $numbers = $data['number'];
        $id_numbers = !empty($data['id_number']) ? $data['id_number'] : null;
        $type = $data['number_type'];
        $custom_tags = $data['number_custom'];

        for($i = 0; $i < count($numbers); $i++){

            $custom_tag = $this->getCustomTag($type[$i], $custom_tags[$i], 5);
            $number = str_replace(' ', '', $numbers[$i]);

            if(!empty($numbers[$i]) && !empty($id_numbers[$i])){

                Number::where('id', $id_numbers[$i])->where('id_contact', $id_contact)->update(['number' => $number, 'id_type' => $type[$i], 'custom_tag' => $custom_tag]);

            }elseif(!empty($numbers[$i]) && empty($id_numbers[$i])){

                Number::insert(['id_contact' => $id_contact, 'number' => $number, 'id_type' => $type[$i], 'custom_tag' => $custom_tag]);

            }else{

                Number::where('id', $id_numbers[$i])->where('id_contact', $id_contact)->delete();

            }


        }

    }

    public function handleSocialNetworks($id_contact, $data){

        $usernames = $data['username'];
        $id_social = !empty($data['id_social']) ? $data['id_social'] : null;
        $network = $data['social_network'];
        $custom_tags = $data['social_custom'];

        for($i = 0; $i < count($usernames); $i++){

            $custom_tag = $this->getCustomTag($network[$i], $custom_tags[$i], 100);

            if(!empty($usernames[$i]) && !empty($id_social[$i])){

                Social::where('id', $id_social[$i])->where('id_contact', $id_contact)->update(['username' => $usernames[$i], 'id_network' => $network[$i], 'custom_tag' => $custom_tag]);

            }elseif(!empty($usernames[$i]) && empty($id_social[$i])){

                Social::insert(['id_contact' => $id_contact, 'username' => $usernames[$i], 'id_network' => $network[$i], 'custom_tag' => $custom_tag]);

            }else{

                Social::where('id', $id_social[$i])->where('id_contact', $id_contact)->delete();

            }

        }

    }

    public function delete($id_contact){

        if(Contact::where('id', $id_contact)->where('active', 1)->update(['active' => 0])){
            $message = ['message_type' => 'success', 'message' => 'The contact was deleted'];
        }else{
            $message = ['message_type' => 'error', 'message' => 'The contact couldn\'t be deleted'];
        }

        return Redirect::to('contacts')->with($message);

    }

    public function search($text){

        $text = preg_replace('/\s+/', '', $text);

        return DB::select('SELECT * FROM 
                            (SELECT CONCAT_WS(" ", name, lastname) AS fullname, name, lastname, address, notes, contacts.id AS id_contact, email, number, username FROM contacts
                            LEFT JOIN emails ON contacts.id = emails.id_contact
                            LEFT JOIN numbers ON contacts.id = numbers.id_contact
                            LEFT JOIN social ON contacts.id = social.id_contact
                            WHERE active = 1
                            GROUP BY id_contact) AS fields 
                            WHERE (REPLACE(fullname, " ", "") LIKE ?
                            OR REPLACE(name, " ", "") LIKE ?
                            OR REPLACE(lastname, " ", "") LIKE ?
                            OR REPLACE(address, " ", "") LIKE ?
                            OR REPLACE(notes, " ", "") LIKE ?
                            OR REPLACE(email, " ", "") LIKE ?
                            OR REPLACE(number, " ", "") LIKE ?
                            OR REPLACE(username, " ", "") LIKE ?)
                            ORDER BY name ASC', ['%'.$text.'%', '%'.$text.'%', '%'.$text.'%', '%'.$text.'%', '%'.$text.'%', '%'.$text.'%', '%'.$text.'%', '%'.$text.'%']);

    }

    public function list(){

        return Contact::where('active', 1)
                            ->select(['contacts.id AS id_contact', 'contacts.*'])
                            ->orderBy('name', 'ASC')
                            ->get();

    }

}
