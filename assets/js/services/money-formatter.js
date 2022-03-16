
class MoneyFormatter {

    formatter = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' });

    format(value) {
        return this.formatter.format(value);
    }
}

export default new MoneyFormatter();
