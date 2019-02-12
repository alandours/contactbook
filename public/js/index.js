import { addEvent } from './helpers.js';
import { getContact, searchContact, addNewField, checkCustomField, checkCustomFieldSocial, loadPreview, deletePhoto } from './views.js';
import openConfirmationWindow from './modal.js';

document.addEventListener('DOMContentLoaded', function(){

	const contactLinks = document.getElementsByClassName('contact-link');
	addEvent(contactLinks, 'click', getContact);

	const newElement = document.getElementsByClassName('btn-new');
	addEvent(newElement, 'click', addNewField);

	const selects = document.getElementsByClassName('type-select');
	addEvent(selects, 'change', checkCustomField);

	const selectsSocial = document.getElementsByClassName('type-select-social');
	addEvent(selectsSocial, 'change', checkCustomFieldSocial);

	const deleteContactBtn = document.getElementsByClassName('delete-contact');
	addEvent(deleteContactBtn, 'click', openConfirmationWindow);

	const searchField = document.getElementsByClassName('search-field');
	addEvent(searchField, 'keyup', searchContact);

	const uploadPhoto = document.getElementsByClassName('photo-input');
	addEvent(uploadPhoto, 'change', loadPreview);

	const deletePhotoLink = document.getElementsByClassName('delete-photo');
	addEvent(deletePhotoLink, 'click', deletePhoto);

});

