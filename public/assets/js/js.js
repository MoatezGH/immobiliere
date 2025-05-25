

function searchFormHandler() {
    const form = document.getElementById("searchForm");

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        // Get the hidden select element
        let category = document.querySelector('[name="category_id"]');
        const category_error=document.getElementById("category_error");

        const selectCategoryWrapper = category.nextElementSibling;

        // Validate category selection
        if (!category.value) {
            if (selectCategoryWrapper) {
                selectCategoryWrapper.style="border-color:red";
            }
            category_error.style="display:block";

            return;
        } else {
            category_error.style="display:none";
            if (selectCategoryWrapper) {
                selectCategoryWrapper.style="border-color:#ced4da";
            }
            

            //niceSelect.classList.remove("error"); // Remove error highlight
        }

        const operation_error=document.getElementById("operation_error");

        let operation = "";
        const radioOperation = document.querySelectorAll(
            'input[name="operation_id"]:checked'
        );
        const selectOperation = document.querySelector(
            'select[name="operation_id"]'
        );
        
        if (radioOperation.length > 0) {
            
            operation = radioOperation[0].value;
        } else {
            operation = selectOperation.value;
            const selectOperationWrapper = selectOperation.nextElementSibling;


            if (!operation) {
                if (selectOperationWrapper) {
                    selectOperationWrapper.style="border-color:red";
                }
                // alert("Veuillez sélectionner une opération.");
                operation_error.style="display:block";
                return;
            } else {
                if (selectOperationWrapper) {
                    selectOperationWrapper.style="border-color:#ced4da";

                }
                operation_error.style="display:none";

            }
        }

        let city = citySelect?.options[citySelect.selectedIndex]?.value || "";
        let area = areaSelect?.options[areaSelect.selectedIndex]?.value || "";
        let minPrice = document.querySelector('[name="min_price"]')?.value || "";
        let maxPrice = document.querySelector('[name="max_price"]')?.value || "";
        let reference = document.querySelector('[name="reference"]')?.value || "";

        let url = "/cherche/";
        const categorySlug = category.value.replace("-", "_");
        const citySlug = city.replace("-", "_");
        const areaSlug = area.replace("-", "_");

        if (categorySlug) url += `${categorySlug}-`;
        if (operation) url += `${operation}-`;
        if (citySlug) url += `${citySlug}-`;
        if (areaSlug) url += `${areaSlug}`;
        url = url.replace(/-$/, "");

        const params = new URLSearchParams();
        if (minPrice) params.append("min_price", minPrice);
        if (maxPrice) params.append("max_price", maxPrice);
        if (reference) params.append("reference", reference);

        if (params.toString()) {
            url += `?${params.toString()}`;
        }

        window.location.href = url;
    });

    
}

document.addEventListener("DOMContentLoaded", searchFormHandler);
