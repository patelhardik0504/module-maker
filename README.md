# ModuleMaker

A Laravel package to generate module boilerplate code with a single command. It creates:

- Model
- Migration
- Resource Controller
- Blade Views (`index`, `create`, `edit`, `view`)
- Routes
- Controller methods with view returns

---

## 📦 Installation

### 1. Install via Composer (local path setup)

In your Laravel project's `composer.json`, add this to the `repositories` section:

```json
"repositories": [
  {
    "type": "path",
    "url": "packages/hardudev/module-maker"
  }
]
