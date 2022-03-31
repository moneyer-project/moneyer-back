import { Controller } from '@hotwired/stimulus'
import { Modal } from 'bootstrap'

export default class extends Controller {

    static targets = [ "modal" ]

    modal = null;

    connect() {
        this.modal = new Modal(this.modalTarget, {});
    }

    open(e) {
        e.preventDefault();
        this.modalTarget.querySelector('.modal-title').textContent = e.params.title;
        this.modalTarget.querySelector('.modal-body').textContent = "Loading ...";
        this.modal.show();

        fetch(e.currentTarget.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                this.modalTarget.querySelector('.modal-body').innerHTML = html;
            });
    }

    close() {
        this.modal.hide();
    }
}
