import { Controller } from '@hotwired/stimulus'

export default class extends Controller {

    static targets = [ "container", "year", "charge" ]

    static values = {
        year: Number,
        prototype: String,
    }

    connect() {
        this.yearTarget.textContent = this.yearValue;
        this.chargesRender(this.yearValue);
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
        this.chargesRender(year);
    }

    chargesRender(year) {
        this.showChargesByYear(year);
        this.addMissedCharges(year);
        this.sortCharges();
    }

    showChargesByYear(year) {
        this.chargeTargets.forEach(charge => {
            charge.classList.add('d-none');
            if (parseInt(charge.dataset.year) === parseInt(year)) {
                charge.classList.remove('d-none');
            }
        });
    }

    addMissedCharges(year) {
        for (let month = 1; month <= 12; month++) {
            const chargeTargetOfMonth = this.chargeTargets
                .filter(chargeTarget => parseInt(chargeTarget.dataset.year) === parseInt(year))
                .filter(chargeTarget => parseInt(chargeTarget.dataset.month) === month);

            if (chargeTargetOfMonth.length === 0) {
                var widget = document.createElement('div');

                widget.innerHTML = this.prototypeValue
                    .replace(/__name__/g, this.getMinKey())
                    .replace(/__year__/g, year)
                    .replace(/__month__/g, month.toString().padStart(2, '0'))
                    .replace(/__date__/g, year + '-' + month.toString().padStart(2, '0') + '-01 00:00:00')
                    .trim();

                this.containerTarget.append(widget.firstChild);
            }
        }
    }

    sortCharges() {
        let items = this.containerTarget.children;

        let itemsArr = [];
        for (let i in items) {
            if (items[i].nodeType === 1) {
                itemsArr.push(items[i]);
            }
        }

        itemsArr.sort(function(a, b) {
            return a.dataset.year !== b.dataset.year
                ?parseInt(a.dataset.year) - parseInt(b.dataset.year)
                : parseInt(a.dataset.month) - parseInt(b.dataset.month);
        });

        for (let i in itemsArr) {
            this.containerTarget.appendChild(itemsArr[i]);
        }
    }

    getMinKey() {
        const keys = this.chargeTargets.map(charge => parseInt(charge.dataset.key));
        let i = 0;
        while (true) {
            if (!keys.includes(i)) {
                return i;
            }

            i++;
        }
    }
}
