
class Dashboard
{
    page = 1;

    userLogout() {
        fetch('/auth', {method: 'DELETE'}).then(function () {
            window.location = '/';
        });

        return false;
    }

    async getUsersList(page) {
        page = Math.abs(page);

        return await fetch('/users?page=' + page, {
            method: 'GET',
            headers: {'Content-type': 'application/json'}
        }).then((response) => {
            return response.json();
        });
    }

    loadingSelector() {
        return document.getElementsByClassName('dashboard_loading').item(0);
    }

    resultSelector() {
        return document.getElementsByClassName('dashboard_result').item(0);
    }

    showLoading() {
        this.loadingSelector().classList.remove('d-none');
        this.resultSelector().classList.add('d-none');
    }

    showResult() {
        this.loadingSelector().classList.add('d-none');
        this.resultSelector().classList.remove('d-none');
    }

    fillTableWithData() {

    }

    init() {
        let that = this;

        this.getUsersList(this.page).then(function (result) {
            console.log(result);
            that.fillTableWithData(result);

            that.showResult();
        });
    }
}

let dashboard = new Dashboard();
dashboard.init();
