import ajax from './ajax.js';
import { urlroot, formatDate, calculateAge, getTag, addEvent } from './helpers.js';

export const getContact = (ev) => {

    ev.preventDefault();

    let msgFlash = document.getElementById('msg-flash');

    if(msgFlash != null){
        msgFlash.parentElement.removeChild(msgFlash);
    }

    const id_contact = ev.target.dataset.id;

    ajax('GET', '/api/contacts/' + id_contact, displayContact);

}

export const displayContact = (contact) => {

    const contactInfo = document.getElementById('contact-info');

    if(contact){

        contact = JSON.parse(contact);

        let [aliases, emails, numbers, social] = [contact.aliases, contact.emails, contact.numbers, contact.social_networks];

        let editBtn = `<a href="${urlroot}/contacts/${contact.id}/edit" class="btn btn-edit"><i class="fa fa-pen"></i>Edit contact</a>`;
        let permalink = `<a href="${urlroot}/contacts/${contact.id}" class="btn btn-permalink"><i class="fa fa-lg fa-link"></i></a>`;

        let photo = `<img src="${urlroot}/img/contacts/${contact.photo}" alt="Profile picture" class="profile-picture">`;

        let fullName = contact.lastname !== null ? contact.name + ' ' + contact.lastname : contact.name;

        let mainInfo = `<div class="main-info"><h2 class="username">${fullName}</h2>`;

        if(contact.birthday !== null){
            mainInfo += `<h3 class="age">${calculateAge(contact.birthday)}</h3>`;
        }

        mainInfo += '</div>';

        let secondaryInfo = '<div class="secondary-info">';

        /* Info first */

        if(contact.met !== null || contact.birthday !== null || contact.address !== null || aliases.length > 0){
        
            secondaryInfo += '<ul class="info-section info-first">';
        
            if(contact.met !== null){

                secondaryInfo += `<li>
                                    <span class="info-tag">Met in</span>
                                    <p>${contact.met}</p>
                                </li>`;

            }

            if(contact.birthday !== null){
                secondaryInfo += `<li>
                                    <span class="info-tag">Birthday</span>
                                    <p>${formatDate(contact.birthday)}</p>
                                </li>`;
            }
                                
            if(contact.address !== null){

                secondaryInfo += `<li>
                                    <span class="info-tag">Address</span>
                                    <a href="https://www.google.com/maps/search/${contact.address}">${contact.address}</a>
                                </li>`;

            }

            if(aliases.length){

                secondaryInfo += `<li>
                                    <span class="info-tag">Alias</span>
                                    <div class="aliases">`;

                aliases.forEach(a => {
                    secondaryInfo += `<p>${a.alias}</p>`;
                });

                secondaryInfo += '</div></li>';

            }

            secondaryInfo += '</ul>';

        }

        /* Info emails */

        if(emails.length){

            secondaryInfo += '<ul class="info-section info-email">';

            emails.forEach(e => {
                secondaryInfo += `<li>
                                    <span class="info-tag">${getTag(e.id_type, 'email', e.custom_tag)}</span>
                                    <a href="mailto:${e.email}">${e.email}</a>
                                </li>`;
            });

            secondaryInfo += '</ul>';
        }

        /* Info numbers */

        if(numbers.length){

            secondaryInfo += '<ul class="info-section info-phone">';

            numbers.forEach(n => {
                secondaryInfo += `<li>
                                    <span class="info-tag">${getTag(n.id_type, 'number', n.custom_tag)}</span>
                                    <a href="tel:${n.number}">${n.number}</a>
                                </li>`;
            });

            secondaryInfo += '</ul>';

        }

        /* Info social */

        if(social.length){

            let socialTag;
            let socialUrl;
            let socialName;

            secondaryInfo += '<ul class="info-section info-social">';

            social.forEach(s => {
                secondaryInfo += '<li>';

                switch(Number(s.id_network)){
                    case 1:
                        socialTag = 'Website';
                        socialUrl = 'https://www.'+s.username;
                        socialName = s.username;
                        break;
                    case 2:
                        socialTag = 'Instagram';
                        socialUrl = 'https://www.instagram.com/'+s.username;
                        socialName = '@'+s.username;
                        break;
                    case 3:
                        socialTag = 'Facebook';
                        socialUrl = 'https://www.facebook.com/'+s.username;
                        socialName = 'facebook.com/'+s.username;
                        break;
                    case 4:
                        socialTag = 'Twitter';
                        socialUrl = 'https://www.twitter.com/'+s.username;
                        socialName = '@'+s.username;
                        break;
                    case 5:
                        socialTag = 'Tumblr';
                        socialUrl = 'https://'+s.username+'.tumblr.com';
                        socialName = s.username+'.tumblr.com';
                        break;
                    case 6:
                        socialTag = 'Snapchat';
                        socialUrl = 'https://www.snapchat.com/add/'+s.username;
                        socialName = '@'+s.username;
                        break;
                    case 7:
                        socialTag = 'Linkedin';
                        socialUrl = 'https://www.linkedin.com/in/'+s.username;
                        socialName = contact.name + ' ' + contact.lastname;
                        break;
                    case 8:
                        socialTag = 'Flickr';
                        socialUrl = 'https://www.flickr.com/'+s.username;
                        socialName = s.username;
                        break;
                    case 9:
                        socialTag = 'Reddit';
                        socialUrl = 'https://www.reddit.com/u/'+s.username;
                        socialName = '/u/'+s.username;
                        break;
                    case 10:
                        socialTag = 'Letterboxd';
                        socialUrl = 'https://www.letterboxd.com/'+s.username;
                        socialName = s.username;
                        break;
                    case 11:
                        socialTag = 'Skype';
                        socialUrl = '#';
                        socialName = s.username;
                        break;
                    case 12:
                        socialTag = 'Behance';
                        socialUrl = 'https://www.behance.net/'+s.username;
                        socialName = s.username;
                        break;
                    case 13:
                        socialTag = 'Pinterest';
                        socialUrl = 'https://www.pinterest.com/'+s.username;
                        socialName = s.username;
                        break;
                    case 14:
                        socialTag = '500px';
                        socialUrl = 'https://www.500px.com/'+s.username;
                        socialName = s.username;
                        break;
                    case 16:
                        socialTag = 'Youtube';
                        socialUrl = 'https://www.youtube.com/'+s.username;
                        socialName = s.username;
                        break;
                    case 999:
                        socialTag = s.custom_tag;
                        socialUrl = 'https://'+s.username;
                        socialName = s.username;
                        break;

                }

                secondaryInfo += `<span class="info-tag">${socialTag}</span><a href="${socialUrl}">${socialName}</a></li>`;

            });

            secondaryInfo += '</ul>';

        }

        /* Info notes */

        if(contact.notes != null){

            secondaryInfo += `<ul class="info-section info-notes">
                                <li>
                                    <div>
                                        <span class="info-tag">Notes</span>
                                        <p>${contact.notes.replace(/(?:\r\n|\r|\n)/g, '<br>')}</p>
                                    </div>
                                </li>
                            </ul>`;

        }

        contactInfo.innerHTML = editBtn + permalink + photo + mainInfo + secondaryInfo;

    }else{

        contactInfo.innerHTML = `<div class="not-found">
                                    <p class="not-found-emoji">&#x1F635</p>
                                    <h2 class="not-found-message">The contact was not found</h2>
                                </div>`;

    }

}

export const searchContact = (ev) => {

    if(ev.target.value != ''){

        ajax('GET', '/api/contacts/search/' + ev.target.value, displayResults);

    }else{

        ajax('GET', '/api/contacts/list', displayResults);

    }

}

export const displayResults = (contacts) => {

    contacts = JSON.parse(contacts);

    let contactList = document.getElementsByClassName('contact-list')[0];

    contactList.innerHTML = '';
    let firstLetter, firstChar, fullName;

    contacts.forEach(contact => {

        firstChar = contact.name.toUpperCase()[0];

        if(firstChar != firstLetter){
            firstLetter = firstChar;
            contactList.innerHTML += `<li class="letter">${firstLetter}</li>`;
        }

        fullName = contact.lastname !== null ? contact.name + ' ' + contact.lastname : contact.name;

        contactList.innerHTML += `<li class="contact"><a href="${urlroot}/contacts/${contact.id_contact}" data-id="${contact.id_contact}" class="contact-link">${fullName}</a></li>`;

    });

    if(contacts.length == 1){

        contactList.innerHTML += `<li class="contact-count">1 contact</li>`;

    }else{

        contactList.innerHTML += `<li class="contact-count">${contacts.length} contacts</li>`;

    }

    const contactLinks = document.getElementsByClassName('contact-link');
	addEvent(contactLinks, 'click', getContact);
    
}

export const addNewField = (ev) => {

    ev.preventDefault();

    const newElement = ev.target.previousElementSibling.cloneNode(true);
    const input = newElement.getElementsByTagName('input')[0];
    const select = newElement.getElementsByTagName('select')[0];
    const custom = newElement.getElementsByClassName('input-custom')[0];
    const id_field = newElement.getElementsByClassName('id_field')[0];
    input.value = '';

    select.value = 1;

    if(custom != null){
        custom.value = '';
        custom.readOnly = true;
    }

    if(id_field != null){
        id_field.value = '';
    }

    if(select != null){
        if(select.classList.contains('type-select-social')){
            select.addEventListener('change', checkCustomFieldSocial);
        }else{
            select.addEventListener('change', checkCustomField);
        }
    }
    

    ev.target.parentNode.insertBefore(newElement, ev.target);

}

export const checkCustomField = (ev, select, value = 5) => {

    select = value == 5 ? ev.target : select;

    if(select.value == value){

        select.nextElementSibling.readOnly = false;

    }else{

        select.nextElementSibling.value = '';
        select.nextElementSibling.readOnly = true;

    }

}

export const checkCustomFieldSocial = (ev) => {
    checkCustomField(this, ev.target, 999);
}

export const loadPreview = (ev) => {

    const input = ev.target;
    const img = input.parentNode.getElementsByTagName('img')[0];
    const deletePhoto = document.getElementsByClassName('delete-photo')[0];
    const noPhoto = document.getElementsByClassName('no-photo')[0];

    noPhoto.checked = false;

    if(input.files && input.files[0]){

        const reader = new FileReader();

        reader.onload = (ev) => {

            img.src = ev.target.result;
            deletePhoto.style.display = 'flex';

        }

        reader.readAsDataURL(input.files[0]);

    }

}

export const deletePhoto = (ev) => {

    ev.preventDefault();

    const deletePhoto = ev.target;
    const input = document.getElementsByClassName('photo-input')[0];
    const img = input.parentNode.getElementsByTagName('img')[0];
    
    const noPhoto = document.getElementsByClassName('no-photo')[0];

    input.value = '';
    img.src = urlroot + '/img/contacts/contact.jpg';
    noPhoto.checked = true;
    deletePhoto.style.display = 'none';

}