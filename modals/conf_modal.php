<div id="confModal" class="modal"  style="display: none;">
    <div class="conf-modal-cont">
        <h2> Confirm Delete </h2>
        <p>Are you sure you want to delete <strong id="deleteProductName"></strong>?</p>
        <form method="POST" action="index.php">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" id="deleteProductId" value="">
            <div class="buttons">
                <button class="button" type="button" id="cancelDeleteBtn">Cancel</button>
                <button class="button-del" type="submit" id="deletePerm">Delete</button>
            </div>
        </form>
    </div>
</div>