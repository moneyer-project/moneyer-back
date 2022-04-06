import { Controller } from '@hotwired/stimulus'

export default class extends Controller {

    static targets = [ "year", "charge" ]

    static values = {
        year: Number
    }

    connect() {
        this.yearTarget.textContent = this.yearValue;
    }

    previous() {
        this.update(this.yearValue - 1);
    }

    next() {
        this.update(this.yearValue + 1);
    }

    update(year) {
        this.yearValue = year;
        this.yearTarget.textContent = this.yearValue;
        this.showChargesByYear(year);
    }

    showChargesByYear(year) {
        this.chargeTargets.forEach(charge => {
            charge.classList.add('d-none');
            if (parseInt(charge.dataset.year) === parseInt(year)) {
                charge.classList.remove('d-none');
            }
        });
    }
}
