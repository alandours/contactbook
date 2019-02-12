<?php

    setlocale(LC_ALL, 'es_ES');

    function calculate_age($birthday){

        $birthday = new DateTime($birthday);
        $now = new Datetime();
        
        return $birthday->diff($now)->y < 100 ? $birthday->diff($now)->y : false;

    }

    function display_birthday($birthday){

        if(calculate_age($birthday)){

            $birthday = new Datetime($birthday);
            return strftime('%e de %B de %Y', $birthday->getTimestamp());

        }else{

            $birthday = new Datetime($birthday);
            return strftime('%e de %B', $birthday->getTimestamp());

        }

    }

    function get_tag($id_tag, $element, $custom_tag){

        $tag_name;
    
        switch($id_tag){
            case 1:
                if($element === 'email'){
                    $tag_name = 'Personal';
                }else{
                    $tag_name = 'Home';
                }
                break;
            case 2:
                $tag_name = 'Mobile';
                break;
            case 3:
                $tag_name = 'Secondary';
                break;
            case 4:
                $tag_name = 'Work';
                break;
            case 5:
                $tag_name = $custom_tag;
                break;
        }
    
        return $tag_name;
        
    }

    function displayData($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }