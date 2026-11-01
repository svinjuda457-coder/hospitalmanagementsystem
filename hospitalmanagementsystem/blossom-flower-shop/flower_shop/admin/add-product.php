<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$edit_product = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $edit_product = $stmt->fetch();
}
$page_title = $edit_product ? 'Edit Flower' : 'Add Flower';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $category_id = (int)$_POST['category_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $discount_price = $_POST['discount_price'] !== '' ? (float)$_POST['discount_price'] : null;
    $stock = (int)$_POST['stock'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';
    $slug = slugify($name) . ($id ? '' : '-' . substr(uniqid(), -4));

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            $image = 'prod_' . time() . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $image);
        }
    }

    if ($id) {
        if ($image) {
            $pdo->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, discount_price=?, stock=?, is_featured=?, is_bestseller=?, status=?, image=? WHERE id=?")
                ->execute([$category_id, $name, $description, $price, $discount_price, $stock, $is_featured, $is_bestseller, $status, $image, $id]);
        } else {
            $pdo->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, discount_price=?, stock=?, is_featured=?, is_bestseller=?, status=? WHERE id=?")
                ->execute([$category_id, $name, $description, $price, $discount_price, $stock, $is_featured, $is_bestseller, $status, $id]);
        }
        flash('success', 'Flower updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, description, price, discount_price, stock, image, is_featured, is_bestseller, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$category_id, $name, $slug, $description, $price, $discount_price, $stock, $image, $is_featured, $is_bestseller, $status]);
        flash('success', 'Flower added successfully.');
    }
    redirect('admin/products.php');
}

$categories = $pdo->query("SELECT * FROM categories WHERE status='active' ORDER BY name")->fetchAll();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?php echo e($msg); ?></div><?php endif; ?>

<div class="dash-card" style="max-width:800px;">
  <form method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="<?php echo $edit_product['id'] ?? ''; ?>">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Flower Name</label>
        <input type="text" name="name" class="form-control" required value="<?php echo e($edit_product['name'] ?? ''); ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
          <option value="">Select category</option>
          <?php foreach ($categories as $c): ?>
            <option value="<?php echo $c['id']; ?>" <?php echo (($edit_product['category_id'] ?? '')==$c['id'])?'selected':''; ?>><?php echo e($c['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?php echo e($edit_product['description'] ?? ''); ?></textarea>
      </div>
      <div class="col-md-4">
        <label class="form-label">Price (₹)</label>
        <input type="number" step="0.01" name="price" class="form-control" required value="<?php echo e($edit_product['price'] ?? ''); ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Discount Price (₹)</label>
        <input type="number" step="0.01" name="discount_price" class="form-control" value="<?php echo e($edit_product['discount_price'] ?? ''); ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Stock Quantity</label>
        <input type="number" name="stock" class="form-control" required value="<?php echo e($edit_product['stock'] ?? '0'); ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Product Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <?php if (!empty($edit_product['image'])): ?><img src="<?php echo product_image_url($edit_product['image']); ?>" class="mt-2" style="width:60px;height:60px;object-fit:cover;border-radius:8px;"><?php endif; ?>
      </div>
      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="active" <?php echo ($edit_product['status'] ?? '')=='active'?'selected':''; ?>>Active</option>
          <option value="inactive" <?php echo ($edit_product['status'] ?? '')=='inactive'?'selected':''; ?>>Inactive</option>
        </select>
      </div>
      <div class="col-md-6 form-check ms-3 mt-4">
        <input type="checkbox" name="is_featured" class="form-check-input" id="isFeatured" <?php echo !empty($edit_product['is_featured'])?'checked':''; ?>>
        <label class="form-check-label" for="isFeatured">Mark as Featured</label>
      </div>
      <div class="col-md-6 form-check ms-3 mt-4">
        <input type="checkbox" name="is_bestseller" class="form-check-input" id="isBestseller" <?php echo !empty($edit_product['is_bestseller'])?'checked':''; ?>>
        <label class="form-check-label" for="isBestseller">Mark as Best Seller</label>
      </div>
      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-bloom"><?php echo $edit_product ? 'Update Flower' : 'Add Flower'; ?></button>
        <a href="<?php echo BASE_URL; ?>admin/products.php" class="btn btn-light">Cancel</a>
      </div>
    </div>
  </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
