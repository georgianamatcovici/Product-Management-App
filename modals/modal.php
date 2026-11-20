<div id="productModal" class="modal" style="display: none;">
    <div class="modal-cont">
        <h2 id="modalTitle"> Add Product </h2>
         <form id="productForm" method="POST" action="index.php" enctype="multipart/form-data">
         <input type="hidden" name="action" value="save">
         <input type="hidden" name="id" id="productId" value="">
         <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" name="name" id="name">
         </div>

         <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3"></textarea>
         </div>

         <div class="form-group">
                <label for="price">Price *</label>
                <input type="number" step="0.01" name="price" id="price">
         </div>
           
         <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image">
        </div>

        <div class="form-group">
                <label for="availability_date">Availability Date</label>
                <input type="date" name="availability_date" id="availability_date">
        </div>

        
        <div class="form-group">
                <label>
                    <input type="checkbox" name="stock_status" id="stock_status" value="1">
                    In Stock
                </label>
        </div>

         <div class="buttons">
                <button class="button" type="button" id="closeModalBtn">Cancel</button>
                <button class="button" type="submit" id="saveBtn">Save</button>
        </div>
        </form>
    </div>
</div>