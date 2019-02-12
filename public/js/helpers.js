export const urlroot = location.origin;

export const calculateAge = (birthdayDate) => {

    let today = new Date();
    let birthday = new Date(birthdayDate);
    let age = today.getFullYear() - birthday.getFullYear();
    let month = today.getMonth() - birthday.getMonth();

    if(month < 0 || (month === 0 && today.getDate() < birthday.getDate())){
        age--;
    }
    
    return (age < 100) ? age : '';

}

export const formatDate = (birthdayDate) => {

    const parts = birthdayDate.split('-');
    const birthday = new Date(parts[0], (parts[1] - 1), parts[2], 12, 0o0, 0o0);

    const options = {month: 'long'};

    if(calculateAge(birthdayDate)){

        return `${birthday.getUTCDate()} de ${birthday.toLocaleDateString('es-AR', options)} de ${birthday.getUTCFullYear()}`;

    }else{

        return `${birthday.getUTCDate()} de ${birthday.toLocaleDateString('es-AR', options)}`;

    }

}

export const getTag = (idTag, element, customTag) => {

    let tagName;

    switch(Number(idTag)){
        case 1:
            if(element === 'email'){
                tagName = 'Personal';
            }else{
                tagName = 'Home';
            }
            break;
        case 2:
            tagName = 'Mobile';
            break;
        case 3:
            tagName = 'Secondary';
            break;
        case 4:
            tagName = 'Work';
            break;
        case 5:
            tagName = customTag;
            break;
    }

    return tagName;
    
}

export const insertAfter = (newNode, referenceNode) => {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    return;
}

export const addEvent = (element, event, callback) => {
    for(let i = 0; i < element.length; i++){
		element[i].addEventListener(event, callback);
	};
}