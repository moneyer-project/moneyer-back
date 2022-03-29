import { Controller } from '@hotwired/stimulus'

export default class extends Controller {

    static targets = [ "table", "prototype" ]

    count = 0;

    connect() {
        this.count = this.tableTarget.querySelectorAll('tr').length;
    }

    add() {
        const tr = document.createElement('tr');
        tr.innerHTML = this.prototypeTarget.innerHTML.replace(/__name__/g, ++this.count);
        this.tableTarget.querySelector('tbody').appendChild(tr);
    }

    delete({ target }) {
        target.closest('tr').remove();
    }
}
