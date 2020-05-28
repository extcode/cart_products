'use strict';

document.addEventListener("DOMContentLoaded", () => {
    const beVariantSelect = document.getElementById('be-variants-select');

    if (!beVariantSelect) {
        return;
    }

    const form = beVariantSelect.closest('form');
    const submitButton = form.querySelector('input[type="submit"]');

    const beVariants = [];
    let defaultOption;
    const selectOptions1 = {};
    const selectOptions2 = {};
    const selectOptions3 = {};

    form.addEventListener('submit',
        function (e) {
            clearPrice();
        }
    );

    /**
     * @param event
     * @param {number} changedOption
     *
     * @returns {void}
     */
    const updateBeVariantField = (event, changedOption) => {
        const attributeOptionSelect1 = form.querySelector('.be-variants-select-attributeOption1');
        const attributeOptionSelect2 = form.querySelector('.be-variants-select-attributeOption2');
        const attributeOptionSelect3 = form.querySelector('.be-variants-select-attributeOption3');

        if (changedOption === 1) {
            updateBeVariantField2();
            if (attributeOptionSelect1.value && attributeOptionSelect2 === null && attributeOptionSelect3 === null) {
                updateView(
                    beVariants[attributeOptionSelect1.value]
                );
            } else {
                clearView();
            }
        } else if (changedOption === 2) {
            updateBeVariantField3();
            if (attributeOptionSelect1.value && attributeOptionSelect2.value && attributeOptionSelect3 === null) {
                updateView(
                    beVariants[attributeOptionSelect1.value][attributeOptionSelect2.value]
                );
            } else {
                clearView();
            }
        } else if (changedOption === 3) {
            if (attributeOptionSelect1.value && attributeOptionSelect2.value && attributeOptionSelect3.value) {
                updateView(
                    beVariants[attributeOptionSelect1.value][attributeOptionSelect2.value][attributeOptionSelect3.value]
                );
            } else {
                clearView();
            }
        }
    }

    /**
     * set price and hidden field for a selected variant
     *
     * @param {array} data
     *
     * @returns {void}
     */
    const updateView = (data) => {
        const selectTag = document.getElementById('be-variants-select');
        const priceTag = document.getElementById('product-price').querySelector('.price');

        if (data) {
            selectTag.value = data['beVariantUid'];
            priceTag.innerHTML = data['regularPrice'];
            submitButton.disabled = false;
        }
    }

    /**
     * clear price and hidden field for a selected variant
     *
     * @returns {void}
     */
    const clearView = () => {
        const selectTag = document.getElementById('be-variants-select');
        selectTag.value = '';

        clearPrice();
    }

    /**
     * clear price for a selected variant
     *
     * @returns {void}
     */
    const clearPrice = () => {
        const priceTag = document.getElementById('product-price').querySelector('.price');
        priceTag.innerHTML = '';

        submitButton.disabled = true;
    }

    /**
     * @returns {void}
     */
    const updateBeVariantField2 = () => {
        const attributeOptionSelect1 = form.querySelector('.be-variants-select-attributeOption1');
        const attributeOptionSelect2 = form.querySelector('.be-variants-select-attributeOption2');
        const attributeOptionSelect3 = form.querySelector('.be-variants-select-attributeOption3');

        if (attributeOptionSelect2 !== null) {
            var options2 = attributeOptionSelect2.getElementsByTagName("option");

            // reset selection
            attributeOptionSelect2.selectedIndex = 0;
            if (attributeOptionSelect3 !== null) {
                attributeOptionSelect3.selectedIndex = 0;
            }

            if (attributeOptionSelect1.value) {
                const beVariant1 = beVariants[attributeOptionSelect1.value];
                const allowedOptions2 = Object.keys(beVariant1);

                for (let i = 0; i < options2.length; i++) {
                    options2[i].disabled = !(options2[i].value === '' || allowedOptions2.includes(options2[i].value));
                }
            } else {
                for (let i = 0; i < options2.length; i++) {
                    options2[i].disabled = true;
                }
            }
        }
    }

    /**
     * @returns {void}
     */
    const updateBeVariantField3 = () => {
        const attributeOptionSelect1 = form.querySelector('.be-variants-select-attributeOption1');
        const attributeOptionSelect2 = form.querySelector('.be-variants-select-attributeOption2');
        const attributeOptionSelect3 = form.querySelector('.be-variants-select-attributeOption3');

        if (attributeOptionSelect3 !== null) {
            var options3 = attributeOptionSelect3.getElementsByTagName("option");

            // reset selection
            attributeOptionSelect3.selectedIndex = 0;

            if (attributeOptionSelect2.value) {
                const beVariant2 = beVariants[attributeOptionSelect1.value][attributeOptionSelect2.value];
                const allowedOptions3 = Object.keys(beVariant2);

                for (let i = 0; i < options3.length; i++) {
                    options3[i].disabled = !(options3[i].value === '' || allowedOptions3.includes(options3[i].value));
                }
            } else {
                for (let i = 0; i < options3.length; i++) {
                    options3[i].disabled = true;
                }
            }
        }
    }

    const retrieveDataFromDataAttributes = () => {
        const beVariantSelect = document.getElementById('be-variants-select');
        const beVariantSelectOptions = beVariantSelect.options

        for (const beVariantSelectOption of beVariantSelectOptions) {
            const selectOptionDataset = beVariantSelectOption.dataset
            let variantData = JSON.parse(JSON.stringify(selectOptionDataset));

            if (beVariantSelectOption.dataset["beVariantSku-1"]) {
                const key1 = beVariantSelectOption.dataset["beVariantSku-1"]

                if (beVariantSelectOption.dataset["beVariantSku-2"]) {
                    const key2 = beVariantSelectOption.dataset["beVariantSku-2"]

                    if (beVariantSelectOption.dataset["beVariantSku-3"]) {
                        const key3 = beVariantSelectOption.dataset["beVariantSku-3"]
                        if (beVariants.indexOf(key1) === -1) {
                            beVariants[key1] = [];
                            if (beVariants[key1].indexOf(key2) === -1) {
                                beVariants[key1][key2] = [];
                            }
                        }
                        beVariants[key1][key2][key3] = variantData;
                    } else {
                        if (beVariants[key1] === undefined) {
                            beVariants[key1] = [];
                        }
                        beVariants[key1][key2] = variantData;
                    }
                } else {
                    beVariants[key1] = variantData;
                }
            }
        }

        for (const beVariantSelectOption of beVariantSelectOptions) {
            if (beVariantSelectOption.value === '') {
                defaultOption = beVariantSelectOption
            }

            const key1 = beVariantSelectOption.dataset["beVariantSku-1"]
            if (key1 && (selectOptions1[key1] === undefined)) {
                selectOptions1[key1] = {
                    sku: key1,
                    title: beVariantSelectOption.dataset["beVariantTitle-1"]
                }
            }

            const key2 = beVariantSelectOption.dataset["beVariantSku-2"]
            if (key2 && (selectOptions2[key2] === undefined)) {
                selectOptions2[key2] = {
                    sku: key2,
                    title: beVariantSelectOption.dataset["beVariantTitle-2"]
                }
            }

            const key3 = beVariantSelectOption.dataset["beVariantSku-3"]
            if (key3 && (selectOptions3[key3] === undefined)) {
                selectOptions3[key3] = {
                    sku: key3,
                    title: beVariantSelectOption.dataset["beVariantTitle-3"]
                }
            }
        }
    }

    const createNewSelectFields = (defaultOption, selectOptions1, selectOptions2, selectOptions3) => {
        const beVariantSelect = document.getElementById('be-variants-select');
        const newFormGroup = document.createElement("div");
        newFormGroup.classList.add('form-group')

        const addOptionsToSelect = (select, selectOptions, disabled=true) => {
            for (const selectOption in selectOptions) {
                const option = document.createElement("option");
                option.value = selectOptions[selectOption].sku;
                option.disabled = disabled;
                option.appendChild(document.createTextNode(selectOptions[selectOption].title));

                select.appendChild(option);
            }
        }

        /**
         * @param defaultOption
         * @param {Object} selectOptions
         * @param {number} optionNumber
         */
        const addSelect = (defaultOption, selectOptions, optionNumber) => {
            if (Object.keys(selectOptions).length >= 1) {
                const label = document.createElement("label");
                label.appendChild(document.createTextNode(beVariantSelect.dataset["beVariantTitle-"+optionNumber]));
                const select = document.createElement("select");
                select.classList.add('be-variants-select-attributeOption'+optionNumber);
                select.classList.add('form-control');

                if (defaultOption) {
                    const newDefaultOption = defaultOption.cloneNode(true);
                    if (optionNumber > 1) {
                        newDefaultOption.disabled = true;
                    }
                    newDefaultOption.selected = true;
                    select.appendChild(newDefaultOption);
                }
                addOptionsToSelect(select, selectOptions, optionNumber > 1);

                select.addEventListener('change', (event) => updateBeVariantField(event,+optionNumber));

                newFormGroup.appendChild(label);
                newFormGroup.appendChild(select);
            }
        }

        addSelect(defaultOption, selectOptions1, 1);
        addSelect(defaultOption, selectOptions2, 2);
        addSelect(defaultOption, selectOptions3, 3);

        const hidden = document.createElement('input');
        hidden.id = 'be-variants-select'
        hidden.name = 'tx_cart_cart[beVariants][1]'
        hidden.type = 'hidden';
        newFormGroup.appendChild(hidden);

        return newFormGroup;
    }

    const render = () => {
        beVariantSelect.after(createNewSelectFields(defaultOption, selectOptions1, selectOptions2, selectOptions3));
        beVariantSelect.remove();
    }

    retrieveDataFromDataAttributes();
    render();

    clearView();
});
