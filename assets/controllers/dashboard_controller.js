import { Controller } from '@hotwired/stimulus';
import moneyFormatter from '../js/services/money-formatter';

export default class extends Controller {

    static targets = ['account', 'externalAccount'];

    static values = {
        url: String
    };

    connect() {
        this.loadAccounts();
    }

    load(e) {
        this.loadAccounts(e);
    }

    loadAccounts(e) {
        let url = e === undefined ? this.urlValue : this.urlValue + '?' + new URLSearchParams({
            month: e.detail.month,
            year: e.detail.year
        });

        fetch(url)
            .then(response => response.text())
            .then(text => JSON.parse(text))
            .then(json => {
                this.feedAccount(json.account);
                this.feedExternalAccounts(Object.values(json.externalAccounts));
            });
    }

    feedAccount(account) {
        if (this.hasAccountTarget) {
            this.accountTarget.setAttribute('data-account-entity-value', JSON.stringify(account));
        }
    }

    feedExternalAccounts(accounts) {
        this.externalAccountTargets.forEach((element) => {
            let account = accounts.find(account => {
                return account.id === parseInt(element.dataset.id);
            });

            if (account !== undefined) {
                element.setAttribute('data-account-entity-value', JSON.stringify(account));
            }
        })
    }
}
