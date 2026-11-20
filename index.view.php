<!DOCTYPE html>
<html>

<head>
    <title>Product Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <div class="header-container">
            <div>
                <h1>Product Management System</h1>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <input type="text" id="searchInput" placeholder="Search product by name" value="<?= $toFind ?>">
            <button class="button" id="buttonSearch" type="submit">
                Search
            </button>
            <button class="button" id="buttonReset" type="submit">
                Reset
            </button>
            <button class="button" id="buttonAdd" type="submit">
                Add Product
            </button>
        </div>
        <div class="table-container">
            <div class="table">
                <div class="table-header">
                    <div class="attribute"> Name </div>
                    <div class="attribute"> Description </div>
                    <div class="attribute"> Price </div>
                    <div class="attribute"> Image </div>
                    <div class="attribute"> Availability Date </div>
                    <div class="attribute"> Stock Status </div>
                    <div class="attribute"> Actions </div>
                </div>

                <?php foreach ($products as $product): ?>
                    <div class="row">

                        <div class="name">
                            <span class="atr">Name:</span>
                            <?= $product['name'] ?>
                        </div>

                        <div class="descr">
                            <span class="atr">Description:</span>
                            <?php
                            if ($product['description'] != NULL && $product['description'] != '')
                                echo $product['description'];
                            else
                                echo '';
                            ?>
                        </div>

                        <div class="price">
                            <span class="atr">Price:</span>
                            $<?= $product['price'] ?>
                        </div>

                        <div class="attr">
                            <span class="atr">Image:</span>
                            <?php if ($product['image'] != NULL && $product['image'] != ''): ?>
                                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="image">
                            <?php else: ?>
                                <span>No image</span>
                            <?php endif; ?>
                        </div>

                        <div class="attr">
                            <span class="atr">Availability Date:</span>
                            <?php
                            if ($product['availability_date'] != NULL && $product['availability_date'] != '')
                                echo $product['availability_date'];
                            else
                                echo '-';
                            ?>
                        </div>

                        <div class="attr">
                            <span class="atr">Stock Status:</span>
                            <?php if ($product['stock_status'] == 1): ?>
                                <span class="in-stock">in stock</span>
                            <?php else: ?>
                                <span class="out-of-stock">out of stock</span>
                            <?php endif; ?>
                        </div>

                        <div class="attr">
                            <span class="atr">Actions:</span>

                            <button type="button" class="btn-edit" data-id="<?= $product['id'] ?>"
                                data-name="<?= $product['name'] ?>" data-description="<?= $product['description'] ?? '' ?>"
                                data-price="<?= $product['price'] ?>" data-date="<?= $product['availability_date'] ?? '' ?>"
                                data-stock="<?= $product['stock_status'] ?>">

                                Edit
                            </button>

                            <button type="button" class="btn-delete" data-id="<?= $product['id'] ?>"
                                data-name="<?= $product['name'] ?>">
                                Delete
                            </button>
                        </div>

                    </div>


                <?php endforeach; ?>
            </div>
        </div>


        <div class="pag">
            <div class="pag-cont">
                <div class="pag-info">
                    Page <?= $currentPage ?> of <?= $nrPages ?> <br> Total products: <?= $totalProducts ?>
                </div>
            </div>


            <div class="page">

                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?= $currentPage - 1 ?>" class="pag-btn">Previous</a>
                <?php else: ?>
                    <span>Previous</span>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $nrPages; $i++): ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($currentPage < $nrPages): ?>
                    <a href="?page=<?= $currentPage + 1 ?>">Next</a>
                <?php else: ?>
                    <span>Next</span>
                <?php endif; ?>
            </div>
        </div>


    </main>
    <?php require 'modals/modal.php'; ?>
    <?php require 'modals/conf_modal.php'; ?>
    <?php require 'modals/message_modal.php'; ?>
    <script src="script.js"></script>
</body>