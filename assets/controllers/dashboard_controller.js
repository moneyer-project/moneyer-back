import { Controller } from '@hotwired/stimulus';
import moneyFormatter from '../js/services/money-formatter';

export default class extends Controller {

    static targets = ['account'];

    static values = {
        url: String
    };

    connect() {
        this.load();
    }

    load(e) {
        this.loadAccount(e);
    }

    loadAccount(e) {
        let url = e === undefined
            ? this.urlValue
            : this.urlValue + '?' + new URLSearchParams({
                month: e.detail.month,
                year: e.detail.year
            });

        fetch(url)
            .then(response => response.text())
            .then(text => JSON.parse(text))
            .then(json => {
                if (this.hasAccountTarget) {
                    this.accountTarget.textContent = moneyFormatter.format(json.account.balance);
                }
            });
    }
}
