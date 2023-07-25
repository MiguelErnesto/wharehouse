export default class RecepcionProductosClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.add = document.getElementById('add')

    this.addListeners()
    this.clean()
  }

  clean() {
    if (document.querySelector('table#listaProductos tbody').innerHTML == '') {
      document.querySelector('table#listaProductos thead').innerHTML = ''
    }
    document.querySelector('input[name="cantidad"]').value = 1
    document.getElementById('producto').value = ''
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

    if (this.add) {
      this.add.addEventListener('click', () => this.onAddProducts())
    }

    $(document).ready(function () {
      console.log('Ready!')
    })
  }

  onAddProducts() {
    if (document.getElementById('producto').value.length == 0) {
      alert('Debe seleccionar un producto')
      document.getElementById('producto').className =
        'form-control border border-danger'
      document.getElementById('producto').placeholder =
        '--- Valor requerido ---'
      document.getElementById('producto').focus()
      return false
    }

    const cantidad = parseInt(
      document.querySelector('input[name="cantidad"]').value,
    )

    this.producto = document.getElementById('producto')
    let idSelected = this.producto.value

    if (!this.productExists(idSelected)) {
      let valueSelected = document.getElementById('producto').options[
        document.getElementById('producto').selectedIndex
      ].text
      document.querySelector('table#listaProductos thead').innerHTML = `<tr>
        <th style="width: 70%">Producto</th>
        <th class='text-center' style="width: 10%">Cantidad</th>
        <th></th>
     </tr>`
      document
        .querySelector('table#listaProductos tbody')
        .append(this.addProductoList(idSelected, valueSelected, cantidad))
    }
    this.clean()
  }

  addProductoList(id, product, qty) {
    const tr = document.createElement('tr')
    tr.id = id
    tr.dataset.id = id
    tr.dataset.cantidad = qty
    tr.innerHTML = `
                    <td>${product}</td>
                    <td class="text-right">${qty}</td>
                    <td class="text-center"><a href="#" class="btn btn-sm btn-danger deleteProductoFromList"> <i class="fas fa-solid fa-trash fa-lg"></i></a></td>
                `
    tr.querySelector('.deleteProductoFromList').addEventListener(
      'click',
      (evt) => {
        if (confirm('¿Desea eliminar el producto de la lista?')) {
          document
            .querySelector(
              `table#listaProductos tbody tr[id="${evt.currentTarget.dataset.id}"]`,
            )
            .remove()
        }
      },
    )

    return tr
  }

  productExists(id) {
    const productsWithId = document.querySelectorAll(
      `table#listaProductos tbody tr[id="${id}"]`,
    )
    if (productsWithId.length > 0) {
      alert('El producto ya fué agregado al listado')
      return true
    }
    return false
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
    evt.stopPropagation()

    if (document.getElementById('fecha').value.length == 0) {
      alert('Debe completar todos los datos del Informe')
      document.getElementById('fecha').className =
        'form-control border border-danger'
      document.getElementById('fecha').placeholder = '--- Valor requerido ---'
      document.getElementById('fecha').focus()
      return false
    }
    if (document.getElementById('nro_informe').value.length == 0) {
      alert('Debe completar todos los datos del Informe')
      document.getElementById('nro_informe').className =
        'form-control border border-danger'
      document.getElementById('nro_informe').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_informe').focus()
      return false
    }
    if (document.getElementById('almacen').value.length == 0) {
      alert('Debe completar todos los datos del Informe')
      document.getElementById('almacen').className =
        'form-control border border-danger'
      document.getElementById('almacen').placeholder = '--- Valor requerido ---'
      document.getElementById('almacen').focus()
      return false
    }

    if (
      document.querySelectorAll('table#listaProductos tbody tr').length == 0
    ) {
      alert('Debe agregar al menos un producto')
      document.getElementById('producto').className =
        'form-control border border-danger'
      document.getElementById('producto').placeholder =
        '--- Valor requerido ---'
      document.getElementById('producto').focus()
      return false
    }

    if (document.getElementById('cantidad').value.length == 0) {
      alert('Debe completar todos los datos del Informe')
      document.getElementById('cantidad').className =
        'form-control border border-danger'
      document.getElementById('cantidad').placeholder =
        '--- Valor requerido ---'
      document.getElementById('cantidad').focus()
      return false
    }

    const data = {
      _token: document.querySelector('input[name="_token"]').value,
      user_id: document.getElementById('user_id').value,
      fecha: document.getElementById('fecha').value,
      nro_informe: document.getElementById('nro_informe').value,
      almacen_id: document.getElementById('almacen').value,
      productos: this.getProductos(),
    }

    $.ajax({
      url: `/recepcion_productos`,
      type: 'POST',
      dataType: 'json',
      data: data,
      context: this,
      success: function (response) {
        window.open(`/recepcion_productos`, '_self')
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  getProductos() {
    let NodelistaProductos = document.querySelectorAll(
      'table#listaProductos tbody tr',
    )
    const listaProductos = []
    for (const producto of NodelistaProductos) {
      listaProductos.unshift({
        id: producto.dataset.id,
        cantidad: producto.dataset.cantidad,
      })
    }
    return listaProductos
  }
}

const RecepcionProductos = async () => {
  var Handler = new RecepcionProductosClass()
}

window.addEventListener('load', RecepcionProductos)
