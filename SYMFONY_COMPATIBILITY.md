# Symfony Compatibility

The `bytic/controllers` package now provides Symfony-compatible controller methods through the `AbstractController` class, making it easier to migrate to Symfony patterns while maintaining backwards compatibility with existing code.

## AbstractController

The `AbstractController` extends the base `Controller` class and adds Symfony-style methods that make controllers more similar to Symfony's AbstractController.

### Usage

Simply extend `AbstractController` instead of `Controller`:

```php
<?php

namespace App\Controllers;

use Nip\Controllers\AbstractController;

class ProductController extends AbstractController
{
    public function index()
    {
        $products = $this->getProducts();
        
        // Use Symfony-style render method
        return $this->render('products/index', [
            'products' => $products
        ]);
    }
    
    public function show($id)
    {
        $product = $this->findProduct($id);
        
        if (!$product) {
            // Use Symfony-style exception
            throw $this->createNotFoundException('Product not found');
        }
        
        // Use Symfony-style JSON response
        return $this->json($product);
    }
}
```

## Available Methods

### Response Methods

#### `json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse`

Returns a JSON response.

```php
return $this->json(['status' => 'success', 'data' => $data]);
```

#### `render(string $view, array $parameters = [], ?Response $response = null): Response`

Renders a view and returns a Response.

```php
return $this->render('products/show', ['product' => $product]);
```

#### `renderView(string $view, array $parameters = []): string`

Renders a view and returns the rendered content as a string.

```php
$html = $this->renderView('emails/welcome', ['user' => $user]);
```

### Redirect Methods

#### `redirectResponse(string $url, int $status = 302): RedirectResponse`

Returns a RedirectResponse to the given URL.

```php
return $this->redirectResponse('/success');
```

#### `redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse`

Returns a RedirectResponse to the given route.

```php
return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
```

#### `generateUrl(string $route, array $parameters = []): string`

Generates a URL from route parameters.

```php
$url = $this->generateUrl('product_edit', ['id' => 123]);
```

### File & Streaming Methods

#### `file(\SplFileInfo|string $file, ?string $fileName = null, string $disposition = 'attachment'): BinaryFileResponse`

Returns a file download response.

```php
return $this->file('/path/to/file.pdf', 'invoice.pdf');
```

#### `stream(\Closure $callback, int $status = 200, array $headers = []): StreamedResponse`

Returns a streamed response.

```php
return $this->stream(function() {
    echo "Streaming data...";
});
```

### Flash Messages

#### `addFlash(string $type, mixed $message): void`

Adds a flash message to the session.

```php
$this->addFlash('success', 'Product saved successfully!');
return $this->redirectToRoute('product_index');
```

### Security Methods

#### `isGranted(mixed $attribute, mixed $subject = null): bool`

Checks if the current user has the given permission.

```php
if ($this->isGranted('ROLE_ADMIN')) {
    // Show admin panel
}
```

#### `denyAccessUnlessGranted(mixed $attribute, mixed $subject = null, string $message = 'Access Denied.'): void`

Throws an exception unless the user has the given permission.

```php
$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You need admin access');
```

#### `getUser(): mixed`

Gets the current authenticated user.

```php
$user = $this->getUser();
if ($user) {
    // User is authenticated
}
```

### Exception Methods

#### `createNotFoundException(string $message = 'Not Found', ?\Throwable $previous = null): NotFoundHttpException`

Creates a 404 Not Found exception.

```php
throw $this->createNotFoundException('Product not found');
```

#### `createAccessDeniedException(string $message = 'Access Denied.', ?\Throwable $previous = null): AccessDeniedException`

Creates a 403 Access Denied exception.

```php
throw $this->createAccessDeniedException('You cannot access this resource');
```

### Form Methods

#### `createForm(string $type, mixed $data = null, array $options = []): mixed`

Creates a form instance.

```php
$form = $this->createForm(ProductType::class, $product);
```

#### `createFormBuilder(mixed $data = null, array $options = []): mixed`

Creates a form builder instance.

```php
$form = $this->createFormBuilder($product)
    ->add('name')
    ->add('price')
    ->getForm();
```

### Configuration

#### `getParameter(string $name): array|bool|string|int|float|\UnitEnum|null`

Gets a configuration parameter.

```php
$apiKey = $this->getParameter('api.key');
```

#### `isCsrfTokenValid(string $id, ?string $token): bool`

Validates a CSRF token.

```php
if ($this->isCsrfTokenValid('delete_product', $request->get('token'))) {
    // Token is valid
}
```

## Backwards Compatibility

The `AbstractController` maintains full backwards compatibility with the existing `Controller` class. All existing traits and methods continue to work as before:

- `payload()` - Access response payload
- `getView()` - Get view object
- `getRequest()` - Get current request
- `forward()` - Forward to another action
- `call()` - Call another action
- All lifecycle hooks (`before()`, `after()`, etc.)

### Migration Path

You can migrate controllers incrementally:

1. **Start**: Extend `AbstractController` instead of `Controller`
2. **Gradually adopt**: Use new Symfony-style methods in new code
3. **Keep existing**: Old code continues to work
4. **Refactor when ready**: Update old methods to Symfony style at your pace

### Differences from Symfony

While the methods are designed to be similar to Symfony's AbstractController, there are some differences:

1. **Dependency Injection**: Uses service locator pattern (`app()`) instead of constructor injection
2. **View Rendering**: Integrates with the existing View system instead of Twig
3. **Response Handling**: Works with the existing ResponsePayload system
4. **Router**: Falls back to basic URL generation if router service is not available

## Example Migration

### Before (using Controller)
```php
class ProductController extends Controller
{
    public function show()
    {
        $product = $this->findProduct();
        $this->payload()->with(['product' => $product]);
        $this->payload()->withDefaultFormat('json');
        return $this->newResponse();
    }
}
```

### After (using AbstractController)
```php
class ProductController extends AbstractController
{
    public function show()
    {
        $product = $this->findProduct();
        return $this->json(['product' => $product]);
    }
}
```

Or with views:

```php
class ProductController extends AbstractController
{
    public function show()
    {
        $product = $this->findProduct();
        return $this->render('products/show', ['product' => $product]);
    }
}
```

## Future Compatibility

This implementation is designed to make future migration to Symfony easier by:

1. Using the same method names and signatures as Symfony
2. Supporting the same exception types
3. Following Symfony's conventions and patterns
4. Maintaining compatibility with Symfony components (HttpFoundation, Security, etc.)

When you're ready to fully migrate to Symfony, you'll be able to:

1. Switch from `Nip\Controllers\AbstractController` to `Symfony\Bundle\FrameworkBundle\Controller\AbstractController`
2. Update dependency injection from service locator to constructor injection
3. Replace view rendering with Twig templates
4. Most controller code will work with minimal changes
