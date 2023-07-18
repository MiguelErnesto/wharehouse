export default class productosClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.addListeners()
  }

  addListeners = () => {
    this.form
      ? this.form.addEventListener('submit', (evt) => this.onValidate(evt))
      : ''

    if (this.btnDelete) {
      for (var i = 0; i < this.btnDelete.length; i += 1) {
        this.btnDelete[i].addEventListener('click', (evt) => this.onDelete(evt))
      }
    }
  }

  onDelete(evt) {
    evt.preventDefault()
    if (confirm('¿Confirma que desea eliminar este Producto?')) {
      this.formIndex = document.getElementById(
        'formIndex_' + evt.currentTarget.dataset.id,
      )
      this.formIndex.submit()
    }
    return false
  }

  onValidate(evt) {
    evt.preventDefault()

    if (document.getElementById('codigo').value.length == 0) {
      document.getElementById('codigo').className =
        'form-control border border-danger'
      document.getElementById('codigo').placeholder = '--- Valor requerido ---'
      document.getElementById('codigo').focus()
      return false
    }
    if (document.getElementById('nombre').value.length == 0) {
      document.getElementById('nombre').className =
        'form-control border border-danger'
      document.getElementById('nombre').placeholder = '--- Valor requerido ---'
      document.getElementById('nombre').focus()
      return false
    }
    if (document.getElementById('descripcion').value.length == 0) {
      document.getElementById('descripcion').className =
        'form-control border border-danger'
      document.getElementById('descripcion').placeholder =
        '--- Valor requerido ---'
      document.getElementById('descripcion').focus()
      return false
    }

    this.form.submit()
  }
}

const productos = async () => {
  var Handler = new productosClass()
}

window.addEventListener('load', productos)
