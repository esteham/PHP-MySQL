<?php
session_start();
ob_start();

// Database connection using USER class
try {
    $db = new USER();
    $pdo = $db->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Fetch existing portfolio data
$portfolioId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($portfolioId <= 0) {
    header('Location: allportfolio.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = :id");
    $stmt->execute([':id' => $portfolioId]);
    $portfolio = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$portfolio) {
        header('Location: allportfolio.php');
        exit;
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    // CSRF check
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Invalid request';
    }

    // Validate inputs
    $url = trim($_POST['port_url'] ?? '');
    $name = trim($_POST['port_name'] ?? '');
    $desc = trim($_POST['port_desc'] ?? '');
    $category = trim($_POST['port_cat'] ?? '');

    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $errors[] = 'Invalid URL format';
    }
    if (strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters';
    }
    
    if (strlen($category) < 2) {
        $errors[] = 'Category must be at least 2 characters';
    }

    // Handle new image upload
    $imageName = $portfolio['port_uploaded_name'];
    if (isset($_FILES['port_image']) && $_FILES['port_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $dir = __DIR__ . '/../../images/portfolio/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file = $_FILES['port_image'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Validate image
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                $errors[] = 'Invalid image format. Allowed: JPG, PNG, GIF, WEBP';
            } elseif ($file['size'] > 20000000) { // 20MB limit
                $errors[] = 'Image size exceeds 20MB limit';
            } else {
                $newName = uniqid('port_') . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $dir . $newName)) {
                    // delete old image
                    if ($imageName && file_exists($dir . $imageName)) {
                        unlink($dir . $imageName);
                    }
                    $imageName = $newName;
                } else {
                    $errors[] = 'Image upload failed';
                }
            }
        } else {
            $errors[] = 'Image file error';
        }
    }

    // If valid, update the database
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE portfolio 
                SET port_url = :url, port_name = :name, port_desc = :desc, 
                    port_cat = :cat, port_uploaded_name = :image
                WHERE id = :id
            ");
            $stmt->execute([
                ':url' => $url,
                ':name' => $name,
                ':desc' => $desc,
                ':cat' => $category,
                ':image' => $imageName,
                ':id' => $portfolioId
            ]);

            $success = true;
            // Refresh portfolio data
            $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = :id");
            $stmt->execute([':id' => $portfolioId]);
            $portfolio = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
    <!-- Tagify core CSS -->
  <link rel="stylesheet" href="https://unpkg.com/@yaireo/tagify/dist/tagify.css">
  <!-- Tagify script -->
  <script src="https://unpkg.com/@yaireo/tagify"></script>

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding-top: 20px;
            padding-bottom: 50px;
        }
        
        .portfolio-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .portfolio-card:hover {
            transform: translateY(-5px);
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .preview-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px dashed #ddd;
            transition: all 0.3s ease;
        }
        
        .preview-container:hover .preview-image {
            border-color: var(--primary-color);
            transform: scale(1.02);
        }
        
        .section-title {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 15px;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 70px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        
        .alert-success {
            background: rgba(76, 201, 240, 0.2);
            border-color: var(--success-color);
            color: #0d6efd;
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .required:after {
            content: " *";
            color: #e63946;
        }
        
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
            
            .preview-image {
                height: 150px;
            }
        }
    </style>

    <div class="col-10">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Modify Portfolio Item</h1>
            <p class="lead text-muted">Update your project details and showcase your work</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> Portfolio updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Error!</strong> Please fix the following issues:
                            <ul class="mt-2 mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="section-title">Edit Project Details</h3>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="action" value="update">
                        
                        <div class="info-box mb-4">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Fields marked with an asterisk (<span class="text-danger">*</span>) are required.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label required">Project Name</label>
                                <input type="text" name="port_name" class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($_POST['port_name'] ?? $portfolio['port_name']) ?>" required>
                                <div class="form-text">Name of your project</div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label required">Project URL</label>
                                <input type="url" name="port_url" class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($_POST['port_url'] ?? $portfolio['port_url']) ?>" required>
                                <div class="form-text">Link to your live project</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea name="port_desc" class="form-control form-control-lg" rows="3"><?= 
                                htmlspecialchars($_POST['port_desc'] ?? $portfolio['port_desc']) 
                            ?></textarea>
                            <div class="form-text">Brief description of your project</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label required">Categories</label>
                            <input type="text" name="port_cat" id="port-cat" class="form-control form-control-lg" 
                                   value="<?= htmlspecialchars($_POST['port_cat'] ?? $portfolio['port_cat']) ?>" required>
                            <div class="form-text">Separate with commas (e.g., HTML, CSS, JavaScript)</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Current Image</label>
                            <div class="preview-container">
                                <?php if ($portfolio['port_uploaded_name']): ?>
                                    <img src="/images/portfolio/<?= $portfolio['port_uploaded_name'] ?>" 
                                         class="preview-image" alt="Current portfolio image">
                                <?php else: ?>
                                    <div class="text-center p-5 border rounded bg-light">
                                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">No image uploaded</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="port_image" class="form-control form-control-lg" accept="image/*">
                            <div class="form-text">Recommended size: 800×600 pixels (max 2MB)</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <a href="allportfolio.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> Back to Portfolio
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Portfolio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Live preview for new image upload
        document.querySelector('input[name="port_image"]').addEventListener('change', function(e) {
            const preview = document.querySelectorAll('.preview-image');
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.forEach(img => {
                        img.src = e.target.result;
                        img.parentElement.querySelector('.fa-image')?.remove();
                        img.parentElement.querySelector('p')?.remove();
                    });
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1) your available categories
    const availableCategories = [
      "Bootstrap 5", "HTML", "JavaScript", "PHP", "CSS", "Jquery", "React"
    ];
    // 2) select the input
    const input = document.getElementById('port_cat');
    // 3) initialize Tagify
    const tagify = new Tagify(input, {
      whitelist: availableCategories,
      dropdown: {
        enabled: 1, // show suggestions after 1 character
        fuzzySearch: true, // match partial strings
        position: 'text', // place suggestions at typed position
      },
      delimiters: ",", // use comma to separate tags
      editTags: false // disable tag-editing after created
    });
  });
</script>