# Axiis-Poc
El siguiente proyecto responde a las consignas solicitadas en el Challenge.

ApiDocumentation dentro del proyecto formato json o vía documenter.postman:

- [Documenter View](https://documenter.getpostman.com/view/10098197/2s9YsJAXeb) 


## Especificaciones
| Techs |       |       |      |      |
| :-------- | :------- | :------- | :------- | :------- |
| Requisitos |`PHP 8.1.2`| `PostgreSQL` | `Composer`|  `Symfony CLI` |

## Instalación

* Instalar dependencias

```bash
  composer install --ignore-platform-reqs
```
* Crear una base de datos en PostgreSQL y nombrarla `sample`.
* Configurar los datos de `.env` para conectar a tu base de datos.
* Ejecutar las migraciones de Symfony mediante el comando:

```bash
  php bin/console doctrine:migration:migrate
```
* Levantar servidor local: 
```bash
  symfony serve
```
* Crear enviroment con URL Local: 
```bash
  standard http://localhost:8000
```
Nota: Por cuestiones practicas no se agregaron certificados SSL.

## Documentación
La API implementa un controllador llamado ProductsController el cual tiene las responsabilidad de
* Listar todos los productos
* Crear productos
* Upsert de productos 
* Listar productos en template

### Arquitectura

* El proyecto está organizado a modo de POC ya que los sistemas wrapeados manejan distintos tipos de estructuras, en el caso de wrappeds e-commerces en PHP las arquitecturas corresponden a una estructura de Bundles.

```bash
axiis-poc/
├── bin
│ └── console
├── config/
│ ├── packages/
│ ├── routes/
│ └── ...
├── migrations/
├── src/
│ ├── Controller/
│ ├── DTO/
│ ├── Entity/
│ ├── Repository/
│ ├── Service/
│ └── ...
├── public/
│ └── index.php
├── config/
│ ├── routes.yaml
│ ├── services.yaml
│ └── ...
├── templates/
│ └── ...
└── ...
```

### Estructura:

El código fuente se organiza de la siguiente manera:

1. Controllers:

* ProductsController
* LoginController

2. ProductDTO

* Mapper de seguridad para inmutabilidad de los objetos Product

3. EventListener:

* AssertionExceptionListener para control de errores respetando estandares de Symfony by TFT.
* TokenValidationListener control de seguridad personalizado para validación de rutas y tokens.


## API Reference
En el repositorio está adjunta la colección de POSTMAN junto con datos de muestra. 

Notas: 
* Se encuentra automatizado el sistema de tokens
* Por cuestiones practicas se hardcodea usuario y contraseña por defecto para un usuario autorizado, se adjunta dentro de la coleccion de postman.


A continuación podrás ver los endpoinsts disponibles:

### ProductController

#### Método: `index`

- **Ruta:** `/products`
- **Métodos HTTP:** GET, OPTIONS
- **Descripción:** Retorna una vista con todos los productos.

#### Método: `getAllProducts`

- **Ruta:** `/api/products/list`
- **Métodos HTTP:** GET, OPTIONS
- **Descripción:** Retorna todos los productos en formato JSON.

#### Método: `createProducts`

- **Ruta:** `/api/products`
- **Métodos HTTP:** POST, OPTIONS
- **Descripción:** Crea nuevos productos basados en datos recibidos en formato JSON.

#### Método: `updateProducts`

- **Ruta:** `/api/products/upsert`
- **Métodos HTTP:** POST, OPTIONS
- **Descripción:** Actualiza productos existentes basados en los datos recibidos en formato JSON.

## Authors

- [@facundoquero](https://github.com/facuquero)


