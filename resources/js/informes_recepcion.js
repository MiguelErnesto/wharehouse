export default class ObjectClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.add = document.getElementById('add')

    this.btnVerInformeRecepcion = document.querySelectorAll(
      '.btnVerInformeRecepcion',
    )

    this.btnPrint = document.querySelectorAll('.btnPrint')
    this.btnPDFExport = document.querySelectorAll('.btnPDFExport')

    this.addListeners()
    this.clean()
  }

  clean() {
    if (document.querySelector('table#listaProductos tbody')) {
      if (
        document.querySelector('table#listaProductos tbody').innerHTML == ''
      ) {
        document.querySelector('table#listaProductos thead').innerHTML = ''
      }
    }
    if (document.querySelector('input[name="cantidad"]')) {
      document.querySelector('input[name="cantidad"]').value = 1
    }
    if (document.querySelector('producto')) {
      document.getElementById('producto').value = ''
    }
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

    if (this.btnVerInformeRecepcion) {
      for (var i = 0; i < this.btnVerInformeRecepcion.length; i += 1) {
        this.btnVerInformeRecepcion[i].addEventListener('click', (evt) =>
          this.onVerInformeRecepcion(evt),
        )
      }
    }

    if (this.btnPrint) {
      for (var i = 0; i < this.btnPrint.length; i += 1) {
        this.btnPrint[i].addEventListener('click', (evt) => this.onPrint(evt))
      }
    }

    if (this.btnPDFExport) {
      for (var i = 0; i < this.btnPDFExport.length; i += 1) {
        this.btnPDFExport[i].addEventListener('click', (evt) =>
          this.onExportPDF(evt),
        )
      }
    }

    $(document).ready(function () {
      console.log('Ready!')
    })
  }

  onPrint(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    let id = evt.currentTarget.dataset.id
    window.open(`informes_recepcion/imprimir/${id}`, '_blank')
  }

  onExportPDF(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    if (confirm(`¿Desea descargar esta información en un PDF?`)) {
      let id = evt.currentTarget.dataset.id
      window.open(`informes_recepcion/exportarPDF/${id}`, '_blank')
    }
  }

  onVerInformeRecepcion(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    let id = evt.currentTarget.dataset.id

    document.getElementById('informe_id').value = id

    // AJAX GET request
    $.ajax({
      url: `informes_recepcion/getDetalles/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        console.log('Fetching data: SUCCESS')
        this.showDetallesInforme(response.informeDetalles[0])
        this.showProductosInforme(response.informeProductos)
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  showProductosInforme(productos) {
    const listaProductos = document.querySelector(
      '#listaProductosInforme tbody',
    )
    listaProductos.innerHTML = ''

    if (!productos.length > 0) {
      listaProductos.innerHTML = `
      <tr>
        <td class='text-center' colspan='4'><i>No hay elementos para mostrar...</i></td>        
      </tr>`
      return false
    }

    productos.forEach((producto) => {
      listaProductos.innerHTML += `
      <tr>
    <td style="width: 15%">${producto.codigo}</td>
    <td style="width: 30%">${producto.nombre}</td>
    <td style="width: 40%">${producto.descripcion}</td>
    <td class='text-right pr-2' style="width: 15%">${
      producto.cantidad ?? '0'
    }</td>
    </tr>`
    })
  }

  showDetallesInforme(informe) {
    document.getElementById('Head').innerHTML = `<tr>
    <td class="font-weight-bold pr-3">
        No. Informe:
    </td>
    <td>
        ${informe.nro_informe}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Almacén:
    </td>
    <td>
        ${informe.almacen}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha:
    </td>
    <td>
        ${informe.fecha}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Creado/Actualizado:
    </td>
    <td>
        ${informe.usuario}
    </td>
    <td></td>
    <td></td>
  </tr>
  <br/>`
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
        <th style="width: 70%">Productos agregados</th>
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
            .querySelector(`table#listaProductos tbody tr[id="${id}"]`)
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
    evt.stopPropagation()
    if (confirm(`¿Confirma que desea eliminar este elemento?`)) {
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
      url: `/informes_recepcion`,
      type: 'POST',
      dataType: 'json',
      data: data,
      context: this,
      success: function (response) {
        alert('Recepción de productos exitosa')
        window.open(`/informes_recepcion`, '_self')
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

const Object = async () => {
  var Handler = new ObjectClass()
}

window.addEventListener('load', Object)
