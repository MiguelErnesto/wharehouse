export default class RecepcionProductosClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.add = document.getElementById('add')

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

    this.add.addEventListener('click', (evt) => this.onAddProducts(evt))

    $(document).ready(function () {
      console.log('Ready!')
    })
  }

  onAddProducts(evt) {
    alert('agregar producto aqui')
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

    if (document.getElementById('fecha').value.length == 0) {
      document.getElementById('fecha').className =
        'form-control border border-danger'
      document.getElementById('fecha').placeholder = '--- Valor requerido ---'
      document.getElementById('fecha').focus()
      return false
    }
    if (document.getElementById('nro_informe').value.length == 0) {
      document.getElementById('nro_informe').className =
        'form-control border border-danger'
      document.getElementById('nro_informe').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_informe').focus()
      return false
    }
    if (document.getElementById('almacen').value.length == 0) {
      document.getElementById('almacen').className =
        'form-control border border-danger'
      document.getElementById('almacen').placeholder = '--- Valor requerido ---'
      document.getElementById('almacen').focus()
      return false
    }

    if (document.getElementById('producto').value.length == 0) {
      document.getElementById('producto').className =
        'form-control border border-danger'
      document.getElementById('producto').placeholder =
        '--- Valor requerido ---'
      document.getElementById('producto').focus()
      return false
    }

    if (document.getElementById('cantidad').value.length == 0) {
      document.getElementById('cantidad').className =
        'form-control border border-danger'
      document.getElementById('cantidad').placeholder =
        '--- Valor requerido ---'
      document.getElementById('cantidad').focus()
      return false
    }

    this.form.submit()
  }
}

const RecepcionProductos = async () => {
  var Handler = new RecepcionProductosClass()
}

window.addEventListener('load', RecepcionProductos)
