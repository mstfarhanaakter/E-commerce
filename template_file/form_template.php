<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Bootstrap Icons (optional) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<main class="p-4">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Card Layout -->
                <div class="card shadow-sm" style="max-width: 600px;">
                    <div class="card-header bg-warning text-black text-center">
                        <h4 class="mb-0 fw-bold">Add New Item</h4>
                    </div>

                    <div class="card-body">
                        <!-- Status Message Placeholder -->
                        <!-- <?php if (!empty($statusMessage)) echo $statusMessage; ?> -->

                        <form action="" method="post">
                            <!-- Input Field Example -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Item Name</label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter name">
                            </div>

                            <!-- Dropdown Example -->
                            <div class="mb-3">
                                <label for="category" class="form-label fw-semibold">Select Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="" disabled selected>Select an option</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <!-- PHP Loop Example:
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </option>
                                    <?php endwhile; ?> -->
                                </select>
                            </div>

                            <!-- Number Input Example -->
                            <div class="mb-3">
                                <label for="price" class="form-label fw-semibold">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter price">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="submit" class="btn btn-warning w-100">
                                <i class="bi bi-plus-circle me-1"></i> Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Bootstrap JS (for modal, dropdowns, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
