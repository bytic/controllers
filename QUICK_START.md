# Quick Start: Using AbstractController

## Before and After Examples

### Example 1: JSON API Response

**Before (using Controller):**
```php
<?php

namespace App\Controllers;

use Nip\Controllers\Controller;

class ApiController extends Controller
{
    public function products()
    {
        $products = $this->getProducts();
        
        $this->payload()->with(['products' => $products]);
        $this->payload()->withDefaultFormat('json');
        
        return $this->newResponse();
    }
}
```

**After (using AbstractController):**
```php
<?php

namespace App\Controllers;

use Nip\Controllers\AbstractController;

class ApiController extends AbstractController
{
    public function products()
    {
        $products = $this->getProducts();
        
        return $this->json(['products' => $products]);
    }
}
```

---

### Example 2: View Rendering

**Before (using Controller):**
```php
public function show($id)
{
    $product = $this->findProduct($id);
    
    $this->getView()->set('product', $product);
    $this->payload()->withDefaultFormat('view');
    
    return $this->newResponse();
}
```

**After (using AbstractController):**
```php
public function show($id)
{
    $product = $this->findProduct($id);
    
    return $this->render('products/show', [
        'product' => $product
    ]);
}
```

---

### Example 3: Redirect with Flash Message

**Before (using Controller):**
```php
public function create()
{
    // ... save product ...
    
    $this->flashRedirect(
        'Product created successfully!',
        '/products',
        'success'
    );
}
```

**After (using AbstractController):**
```php
public function create()
{
    // ... save product ...
    
    $this->addFlash('success', 'Product created successfully!');
    
    return $this->redirectResponse('/products');
}
```

---

### Example 4: 404 Not Found

**Before (using Controller):**
```php
public function show($id)
{
    $product = $this->findProduct($id);
    
    if (!$product) {
        $this->dispatchNotFoundResponse();
    }
    
    // ... render product ...
}
```

**After (using AbstractController):**
```php
public function show($id)
{
    $product = $this->findProduct($id);
    
    if (!$product) {
        throw $this->createNotFoundException('Product not found');
    }
    
    return $this->render('products/show', ['product' => $product]);
}
```

---

### Example 5: Security Check

**Before (using Controller):**
```php
public function delete($id)
{
    // Manual check needed
    if (!$this->userIsAdmin()) {
        $this->dispatchAccessDeniedResponse();
    }
    
    // ... delete product ...
}
```

**After (using AbstractController):**
```php
public function delete($id)
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
    // ... delete product ...
    
    return $this->redirectToRoute('products_index');
}
```

---

### Example 6: File Download

**Before (using Controller):**
```php
public function downloadInvoice($id)
{
    $path = "/path/to/invoice-{$id}.pdf";
    
    $response = $this->getResponseFactory()->file($path, "invoice.pdf");
    
    return $response;
}
```

**After (using AbstractController):**
```php
public function downloadInvoice($id)
{
    $path = "/path/to/invoice-{$id}.pdf";
    
    return $this->file($path, "invoice.pdf");
}
```

---

## Quick Reference

### Response Methods

| Old Way | New Way |
|---------|---------|
| `$this->payload()->with($data);`<br>`$this->payload()->withDefaultFormat('json');`<br>`return $this->newResponse();` | `return $this->json($data);` |
| `$this->getView()->set($key, $value);`<br>`return $this->newResponse();` | `return $this->render($view, [$key => $value]);` |
| `$this->redirect($url);` | `return $this->redirectResponse($url);` |

### Security Methods

| Old Way | New Way |
|---------|---------|
| `$this->dispatchNotFoundResponse();` | `throw $this->createNotFoundException();` |
| `$this->dispatchAccessDeniedResponse();` | `throw $this->createAccessDeniedException();` |
| Custom checks | `$this->denyAccessUnlessGranted('ROLE_ADMIN');` |
| Custom user retrieval | `$user = $this->getUser();` |

### Flash Messages

| Old Way | New Way |
|---------|---------|
| `app('flash.messages')->add($name, $type, $msg);` | `$this->addFlash($type, $msg);` |

## Getting Started

1. **Change your controller base class:**
   ```php
   // Before
   class MyController extends Controller
   
   // After  
   class MyController extends AbstractController
   ```

2. **Start using Symfony methods in new code**

3. **Keep existing code working** - No need to change everything at once!

4. **Refactor gradually** - Update methods as you work on them

## Benefits

✅ **Cleaner Code** - Less boilerplate, more expressive  
✅ **Symfony Familiar** - Standard patterns developers know  
✅ **Type Safety** - Better IDE support and type checking  
✅ **Future Proof** - Easier migration to full Symfony later  
✅ **No Breaking Changes** - Existing code continues to work  

## More Information

- 📖 [Full Documentation](SYMFONY_COMPATIBILITY.md) - Complete guide with all methods
- 📋 [Migration Summary](MIGRATION_SUMMARY.md) - Detailed migration information
- 💻 [Example Controller](tests/fixtures/Controllers/SymfonyStyleController.php) - Working examples
