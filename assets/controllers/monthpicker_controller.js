import { Controller } from '@hotwired/stimulus'

export default class extends Controller {

    static targets = ['summary', 'month', 'year', 'yearSelect'];

    static values = {
        year: {type: Number, default: (new Date()).getFullYear()},
        month: {type: Number, default: (new Date()).getMonth() + 1},
        monthLabel: {type: String, default: ''},
    };

    static classes = ["active"];

    connect() {
        this.summaryTarget.textContent = `${this.monthLabelValue} ${this.yearValue}`;

        this.yearTargets.forEach(target => {
            if (parseInt(target.value) === this.yearValue) {
                target.setAttribute('selected', 'selected');
            }
        });

        this.updateMonthClass();
    }

    changeYear({params}) {
        this.yearValue = this.yearSelectTarget.value;
    }

    changeMonth({params}) {
        this.monthValue = params.value;
        this.summaryTarget.textContent = `${params.label} ${this.yearValue}`;
        this.updateMonthClass();

        window.location.href = '?year=' + this.yearValue + '&month=' + this.monthValue;
    }

    updateMonthClass() {
        this.monthTargets.forEach(target => {
            target.getAttribute("data-monthpicker-value-param") === this.monthValue.toString()
                ? target.classList.add(this.activeClass)
                : target.classList.remove(this.activeClass);
        });
    }
}
