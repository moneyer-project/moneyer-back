import { Controller } from '@hotwired/stimulus'
import { useApplication, useDispatch } from 'stimulus-use'

export default class extends Controller {

    static targets = ['summary', 'month'];

    static values = {
        year: {type: Number, default: (new Date()).getFullYear()},
        month: {type: Number, default: (new Date()).getMonth() + 1},
    };

    month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    static classes = ["active"];

    connect() {
        useApplication(this);
        useDispatch(this, {debug: true});
        this.summaryTarget.textContent = `${this.month[this.monthValue - 1]} ${this.yearValue}`;
    }

    changeMonth({params}) {
        this.monthValue = params.month;
        this.summaryTarget.textContent = `${this.month[this.monthValue - 1]} ${this.yearValue}`;

        this.updateMonthClass();
        this.dispatchEventDateChange();
    }

    updateMonthClass() {
        this.monthTargets.forEach(target => {
            target.getAttribute("data-monthpicker-month-param") === this.monthValue.toString()
                ? target.classList.add(this.activeClass)
                : target.classList.remove(this.activeClass);
        });
    }

    dispatchEventDateChange() {
        this.dispatch('date-change', {
            month: this.monthValue,
            year: this.yearValue
        })
    }
}
