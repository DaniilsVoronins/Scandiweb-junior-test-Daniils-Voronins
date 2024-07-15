document.addEventListener('DOMContentLoaded', () => {
    const productTypeSwitcher = document.getElementById('productType');
    const typeSpecificFields = document.getElementById('type-specific-fields');
    const productForm = document.getElementById('product_form');
    const notifications = document.getElementById('notifications');

    productTypeSwitcher.addEventListener('change', () => {
        const type = productTypeSwitcher.value;
        typeSpecificFields.innerHTML = '';

        switch (type) {
            case 'DVD':
                typeSpecificFields.innerHTML = `
                    <label for="size">Size (MB)</label>
                    <input type="number" id="size" name="size" required>
                    <p>Please, provide size in MB</p>
                `;
                break;
            case 'Book':
                typeSpecificFields.innerHTML = `
                    <label for="weight">Weight (Kg)</label>
                    <input type="number" id="weight" name="weight" required>
                    <p>Please, provide weight in Kg</p>
                `;
                break;
            case 'Furniture':
                typeSpecificFields.innerHTML = `
                    <label for="height">Height (CM)</label>
                    <input type="number" id="height" name="height" required>
                    
                    <label for="width">Width (CM)</label>
                    <input type="number" id="width" name="width" required>
                    
                    <label for="length">Length (CM)</label>
                    <input type="number" id="length" name="length" required>
                    <p>Please, provide dimensions in HxWxL format</p>
                `;
                break;
        }
    });

    productForm.addEventListener('submit', (event) => {
        event.preventDefault();
        notifications.textContent = '';
        
        const formData = new FormData(productForm);

        fetch('add_product.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data => {
            if (data.success) {
                window.location.href = 'index.html';
            } else {
                notifications.textContent = data.message;
            }
        }).catch(error => {
            notifications.textContent = 'An error occurred';
            console.error('Error:', error);
        });
    });
});
