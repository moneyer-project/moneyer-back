import { Controller } from '@hotwired/stimulus'

export default class extends Controller {

    static targets = ['search', 'container']

    key = 0;

    addPayer() {
        if (this.searchTarget.value.length > 0) {
            const iconClose = document.createElement('i');
            iconClose.classList.add('fe', 'fe-close');

            const closeButton = document.createElement('button');
            closeButton.setAttribute('type', 'button');
            closeButton.setAttribute('data-action', 'click->payer-list#removePayer');
            closeButton.classList.add('btn', 'btn-sm', 'btn-danger');
            closeButton.appendChild(iconClose);

            const li = document.createElement('li');
            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            li.appendChild(document.createTextNode(this.searchTarget.value));
            li.appendChild(closeButton);

            this.containerTarget.appendChild(li);

            this.key++;
        }
    }

    removePayer(event) {
        event.currentTarget.closest('li').remove();
    }
}
