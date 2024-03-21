<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="form-title"><?= isset($empResults['id']) ? "Employee with id: {$empResults['id']} " : 'There is no Employee' ?></h1>
                <form action="index.php" method="post" class="p-4">
                    <input type="hidden" name="id" value="<?= $empResults['id'] ?? '' ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= $empResults['name'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= $empResults['phone'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= $empResults['address'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $empResults['email'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="action" value="Insert" class="btn btn-success me-2">Insert</button>
                        <button type="submit" name="action" value="Update" class="btn btn-warning me-2">Update</button>
                        <button type="submit" name="action" value="Delete" class="btn btn-danger me-2">Delete</button>
                        <button type="submit" name="action" value="Prev" class="btn <?= $employeeIndex <= 0 ? 'btn-outline-info' : 'btn-info' ?> me-2">Previous</button>
                        <button type="submit" name="action" value="Next" class="btn <?= $employeeIndex >= $dom->getElementsByTagName('employee')->length - 1 ? 'btn-outline-info' : 'btn-info' ?> me-2">Next</button>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search Employees" name="searchValue" aria-label="Search Value">
                            <button class="btn btn-secondary" type="submit" name="action" value="Search">Search</button>
                        </div>
                    </div>
                </form>
                <?php displaySearchResults($searchResults)  ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>