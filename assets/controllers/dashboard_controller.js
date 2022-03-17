import { Controller } from '@hotwired/stimulus';
import moneyFormatter from '../js/services/money-formatter';

export default class extends Controller {

    static targets = ['account', 'externalAccount'];

    static values = {
        urlAccounts: String,
        urlTransfers: String,
    };

    connect() {
        this.loadAccounts();
        this.loadTransfers();
    }

    load(e) {
        this.loadAccounts(e);
        this.loadTransfers(e);
    }

    loadAccounts(e) {
        let url = e === undefined ? this.urlAccountsValue : this.urlAccountsValue + '?' + new URLSearchParams({
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

    loadTransfers(e) {
        let url = e === undefined ? this.urlTransfersValue : this.urlTransfersValue + '?' + new URLSearchParams({
            month: e.detail.month,
            year: e.detail.year
        });

        fetch(url)
            .then(response => response.text())
            .then(text => JSON.parse(text))
            .then(json => {
                this.feedTransfers(json.transfers);
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

    feedTransfers(transfers) {
        console.log(transfers);
    }
}
