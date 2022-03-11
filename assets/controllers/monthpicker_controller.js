import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ['summary', 'month'];

    static values = {
        url: String,
        year: {type: Number, default: (new Date()).getFullYear()},
        month: {type: Number, default: (new Date()).getMonth() + 1},
    };

    month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    static classes = ["active"];

    connect() {
        this.summaryTarget.textContent = `${this.month[this.monthValue - 1]} ${this.yearValue}`;
    }

    changeMonth({params}) {
        this.monthValue = params.month;
        this.summaryTarget.textContent = `${this.month[this.monthValue - 1]} ${this.yearValue}`;

        this.updateMonthClass();

        this.load();
    }

    updateMonthClass() {
        this.monthTargets.forEach(target => {
            target.getAttribute("data-monthpicker-month-param") === this.monthValue.toString()
                ? target.classList.add(this.activeClass)
                : target.classList.remove(this.activeClass);
        });
    }

    load() {
        console.log('load', this.monthValue, this.yearValue);
        fetch(this.urlValue)
            .then(response => response.text())
            .then(json => console.log(json));
    }
}
