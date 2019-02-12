import { urlroot, addEvent } from './helpers.js';

function openConfirmationWindow(ev){
    ev.preventDefault();

    const body = document.getElementsByTagName('body')[0];
    const idContact = this.dataset.id;

    const modalOptions = {
        title: 'Are you sure you want to delete this contact?',
        confirmationText: 'Delete',
        confirmationClass: 'btn-r',
        cancelText: 'Cancel',
        cancelClass: 'btn-m',
        idContact: idContact
    };

    const modalWindow = createModalWindow(modalOptions);

    body.appendChild(modalWindow);

    addCloseEvents();

}

function createModalWindow(options){

    const modalWindow = document.createElement('div');
    modalWindow.className = 'modal-container';
    modalWindow.innerHTML = `<div class="modal">
                                <a href="#" class="modal-close"><i class="fa fa-lg fa-times"></i></a>
                                <p class="modal-title">${options.title}</p>
                                <a href="${urlroot}/contacts/${options.idContact}/delete"type="submit" class="btn btn-modal btn-modal-confirm ${options.confirmationClass}">${options.confirmationText}</a>
                                <a href="#" class="btn btn-modal btn-modal-cancel ${options.cancelClass}">${options.cancelText}</a>
                            </div>`;

    return modalWindow;

}

function closeModalWindow(ev){

    if(ev != undefined){
        ev.preventDefault();
    }

    const body = document.getElementsByTagName('body')[0];
    const modalWindow = document.getElementsByClassName('modal-container')[0];

    if(modalWindow){
        body.removeChild(modalWindow);
    }

}

function addCloseEvents(){

    const cancelBtn = document.getElementsByClassName('btn-modal-cancel');
    addEvent(cancelBtn, 'click', closeModalWindow);

    const modalClose = document.getElementsByClassName('modal-close');
    addEvent(modalClose, 'click', closeModalWindow);

    const body = document.getElementsByTagName('body')[0];
    body.addEventListener('keydown', (ev) => {

        if(ev.key == 'Escape'){
            closeModalWindow();
        }

    });

    const modalContainer = document.getElementsByClassName('modal-container')[0];
    modalContainer.addEventListener('click', (ev) => {

        if(ev.target.className == 'modal-container'){
            closeModalWindow();
        }

    });

}

export default openConfirmationWindow;







