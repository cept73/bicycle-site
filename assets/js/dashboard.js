
class Dashboard
{
    LAYER_RESULT    = 'dashboard__result';
    LAYER_IS_EMPTY  = 'dashboard__empty_result';
    STATUS_OK       = 'ok';
    STATUS_ERROR    = 'error';

    items           = [];
    page            = 1;
    lastPage        = 1;
    loading         = false;
    retries         = 0;
    maxTries        = 2;

    __blocks        = {};

    userLogout() {
        fetch('/auth', {method: 'DELETE'}).then(function () {
            window.location = '/';
        });

        return false;
    }

    loadPage(page) {
        let that = this;
        page = this.getCorrectPage(page);

        this.loading = true;

        $.get('/students/page/' + page)
            .done(async function (data) {
                that.loading = false;
                that.clearTries();

                if (data.status === that.STATUS_OK) {
                    that.populateObjectsFromAjaxData(data.result);
                    that.renderPage();

                    if (that.items.length === 0) {
                        that.showLayer(that.LAYER_IS_EMPTY);
                    } else {
                        that.showLayer(that.LAYER_RESULT);
                    }

                    return that.STATUS_OK;
                }

                return that.STATUS_ERROR;
            })
            .fail(async function () {
                if (that.isNeedToRetry()) {
                    setTimeout(function () {
                        that.loadPage(page);
                    }, 500);
                }

                return that.STATUS_ERROR;
            })
    }

    renderPage() {
        let that = this;

        let templateBlock   = 'list_item';
        let statusOnClass   = this.__blocks['list_item__active_class'].innerText;
        let statusOffClass  = this.__blocks['list_item__not_active_class'].innerText;
        let pageItemBlock   = 'page_item';
        let pageNextBlock   = 'to_next_page';
        let pagePrevBlock   = 'to_prev_page';

        $('#dashboard__result__list').html('');
        this.items.forEach(function (item) {
            let rowProperties = item;
            rowProperties['status_position'] = item['active'] ? 'on' : 'off';
            rowProperties['status_class'] = item['active'] ? statusOnClass : statusOffClass;

            let row = that.__getBlockHtml(templateBlock, rowProperties)
            $('#dashboard__result__list').append(row)
        })

        let html = '';
        if (this.page > 1) {
            html += that.__getBlockHtml(pagePrevBlock);
        }
        for (let index = 1; index <= this.lastPage; index ++) {
            let pageProperties = {
                'index'     : index,
                'active'    : this.page === index ? ' active':''
            }
            html += that.__getBlockHtml(pageItemBlock, pageProperties);
        }
        if (this.page < this.lastPage) {
            html += that.__getBlockHtml(pageNextBlock);
        }

        $('#dashboard__result__pagination').html(html);
    }

    showLayer(activeLayer) {
        $('.dashboard__layer').addClass('d-none');
        $('#' + activeLayer).removeClass('d-none');
    }

    getCorrectPage(page) {
        page = Math.abs(page);

        if (page < 1) {
            page = 1;
        }
        if (page > this.lastPage) {
            page = this.lastPage;
        }

        return page;
    }

    goPrev() {
        this.page = this.getCorrectPage(this.page - 1);
        this.loadPage(this.page);
        return false;
    }

    goNext() {
        this.page = this.getCorrectPage(this.page + 1);
        this.loadPage(this.page);
        return false;
    }

    goIndex(index) {
        this.page = this.getCorrectPage(index);
        this.loadPage(this.page);
        return false;
    }

    populateObjectsFromAjaxData(data) {
        this.items      = data.items;
        this.page       = data.page.index;
        this.lastPage   = data.page.count;
    }

    isNeedToRetry() {
        return ++this.retries < this.maxTries;
    }

    clearTries() {
        this.retries = 0;
    }

    __getBlockHtml(blockName, data = {}) {
        let html = this.__blocks[blockName].outerHTML;

        Object.entries(data).forEach(function (item) {
            let replaceFrom = '{' + item[0] + '}',
                replaceTo = '' + item[1];

            html = html.replaceAll(replaceFrom, replaceTo);
        });

        return html;
    }

    __loadTemplateBlocks() {
        let that = this;

        $('.template-item').each(function (index, item) {
            let blockId = item.dataset.blockId;
            item.classList.remove('template-item')
            delete(item.dataset.blockId);

            that.__blocks[blockId] = item;
            $(item).remove();
        })
    }

    init() {
        this.__loadTemplateBlocks();

        this.loadPage(this.page);
    }
}

let dashboard = new Dashboard();
dashboard.init();
