
class KeyHelper {

    min(data, fn) {
        const keys = data.map(fn);
        let key = 0;
        while (true) {
            if (!keys.includes(key)) {
                return key;
            }

            key++;
        }
    }
}

export default new KeyHelper();
