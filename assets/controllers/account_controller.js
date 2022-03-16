import { Controller } from '@hotwired/stimulus';
import moneyFormatter from '../js/services/money-formatter';

export default class extends Controller {

    static targets = ['balance', 'income', 'expense'];

    static values = { entity: Object }

    properties = [
        { name: 'balance', value: (value) => moneyFormatter.format(value) },
        { name: 'income', value: (value) => moneyFormatter.format(value) },
        { name: 'expense', value: (value) => moneyFormatter.format(value) },
    ];

    entityValueChanged() {
        this.properties.forEach(property => {
            const target = property.name + 'Target';
            const validation = target.charAt(0).toUpperCase() + target.slice(1);

            if (this[`has${validation}`]) {
                this[target].textContent = this.entityValue.hasOwnProperty(property['name'])
                    ? property.value(this.entityValue[property['name']])
                    : '-';
            }
        });
    }
}
