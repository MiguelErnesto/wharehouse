export default class ObjectClass {
  constructor() {
    this.form = document.getElementById('form') ?? null
    this.btnDelete = document.querySelectorAll('.btnDelete') ?? null
    this.add = document.getElementById('add')

    this.btnVerDetalles = document.querySelectorAll('.btnVerDetalles')

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

    if (this.btnVerDetalles) {
      for (var i = 0; i < this.btnVerDetalles.length; i += 1) {
        this.btnVerDetalles[i].addEventListener('click', (evt) =>
          this.onVerDetalles(evt),
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
    window.open(`facturas/imprimir/${id}`, '_blank')
  }

  onExportPDF(evt) {
    evt.preventDefault()
    evt.stopPropagation()
    if (confirm(`¿Desea descargar esta información en un PDF?`)) {
      let id = evt.currentTarget.dataset.id
      window.open(`facturas/exportarPDF/${id}`, '_blank')
    }
  }

  onVerDetalles(evt) {
    evt.preventDefault()
    evt.stopPropagation()

    let id = evt.currentTarget.dataset.id

    document.getElementById('informe_id').value = id

    // AJAX GET request
    $.ajax({
      url: `facturas/getDetalles/${id}`,
      type: 'get',
      dataType: 'json',
      context: this,
      success: function (response) {
        console.log('Fetching data: SUCCESS')
        this.showDetalles(response.detalles[0])
        this.showProductos(response.productos)
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
      },
    })
  }

  showProductos(productos) {
    const listaProductos = document.querySelector(
      '#listaProductosInforme tbody',
    )
    listaProductos.innerHTML = ''

    if (!productos.length > 0) {
      listaProductos.innerHTML = `
      <tr>
        <td class='text-center' colspan='2'><i>No hay elementos para mostrar...</i></td>        
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

  showDetalles(informe) {
    document.getElementById('Head').innerHTML = `
  <tr>
    <td class='font-weight-bold pr-3'>
        No. Factura:
    </td>
    <td>
        ${informe.nro_factura}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class='font-weight-bold pr-3'>
       Entidad:
    </td>
    <td>
       ${informe.entidad}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class='font-weight-bold pr-3'>
        Fecha del modelo:
    </td>
    <td>
        ${informe.fecha_modelo}
    </td>
    <td></td>
    <td></td>
  </tr>
    
  <tr>
  <td class="font-weight-bold pt-3">
      Datos del Registro:
  </td>
  <td class="pt-3">
    ${informe.datos_registro}
  </td>
  <td></td>
  <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Operaciones:
    </td>
    <td>
        ${informe.operaciones}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Moneda del pago:
    </td>
    <td>
        ${informe.moneda_pago}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
  <td class="font-weight-bold">
      Porciento:
  </td>
  <td>
      ${informe.porciento} %
  </td>
  <td></td>
  <td></td>
</tr>

  <tr>
  <td class="font-weight-bold pt-3">
      Transportista:
  </td>
  <td class="pt-3">
    ${informe.transportista}
  </td>
  <td></td>
  <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Transportador:
    </td>
    <td>
        ${informe.persona_transportador}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha que recepciona:
    </td>
    <td>
        ${informe.fecha_recepcion_transportador}
    </td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="font-weight-bold pt-3">
        Entrega:
    </td>
    <td class="pt-3">
        ${informe.persona_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha de entrega:
    </td>
    <td>
        ${informe.fecha_entrega}
    </td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="font-weight-bold pt-3">
        Recibe:
    </td>
    <td class="pt-3">
        ${informe.persona_recibe}
    </td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td class="font-weight-bold">
        Fecha que recibe:
    </td>
    <td>
        ${informe.fecha_recepcion}
    </td>
    <td></td>
    <td></td>
  </tr>

  <tr>
    <td class="font-weight-bold pt-3">
        Contabiliza:
    </td>
    <td class="pt-3">
        ${informe.persona_contabiliza}
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
  <tr>
    <td class="font-weight-bold pt-3">
        Importe total de la entrega:
    </td>
    <td class="pt-3 pl-3">
       $ ${informe.importe_total}
    </td>
    <td></td>
    <td></td>
  </tr>
  <br/>`
  }

  formated_datetime(fecha) {
    // Mostrar Fecha del movimiento en formato ('dd/mm/yy')
    let inputDate = new Date(fecha)
    let date = inputDate.getDate()
    let month = inputDate.getMonth() + 1
    let year = inputDate.getFullYear()
    date = date.toString().padStart(2, '0')
    month = month.toString().padStart(2, '0')
    const fecha_formato = date + '-' + month + '-' + year

    return fecha_formato + ' ' + inputDate.toLocaleTimeString()
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
        <th style="width: 55%">Productos agregados</th>
        <th class='text-right' style="width: 15%">Cantidad</th>
        <th></th>
     </tr>`
      document
        .querySelector('table#listaProductos tbody')
        .append(this.addProductoList(idSelected, valueSelected, cantidad))
    }
    this.clean()
  }

  addProductoList(id, product, cantidad) {
    const tr = document.createElement('tr')
    tr.id = id
    tr.dataset.id = id
    tr.dataset.cantidad = cantidad
    tr.innerHTML = `
                    <td>${product}</td>
                    <td class="text-right">${cantidad}</td>
                    <td class="text-center pl-5 pr-3"><a href="#" class="btn btn-sm btn-danger deleteProductoFromList"> <i class="fas fa-solid fa-trash fa-lg"></i></a></td>
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

    if (document.getElementById('fecha_modelo').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('fecha').className =
        'form-control border border-danger'
      document.getElementById('fecha_modelo').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_modelo').focus()
      return false
    }
    if (document.getElementById('nro_factura').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('nro_factura').className =
        'form-control border border-danger'
      document.getElementById('nro_factura').placeholder =
        '--- Valor requerido ---'
      document.getElementById('nro_factura').focus()
      return false
    }
    if (document.getElementById('entidad').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('entidad').className =
        'form-control border border-danger'
      document.getElementById('entidad').placeholder = '--- Valor requerido ---'
      document.getElementById('entidad').focus()
      return false
    }
    if (document.getElementById('moneda_pago').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('moneda_pago').className =
        'form-control border border-danger'
      document.getElementById('moneda_pago').placeholder =
        '--- Valor requerido ---'
      document.getElementById('moneda_pago').focus()
      return false
    }
    if (document.getElementById('porciento').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('porciento').className =
        'form-control border border-danger'
      document.getElementById('porciento').placeholder =
        '--- Valor requerido ---'
      document.getElementById('porciento').focus()
      return false
    }
    if (isNaN(document.getElementById('porciento').value)) {
      alert('El valor debe ser un número')
      document.getElementById('porciento').className =
        'form-control border border-danger'
      document.getElementById('porciento').placeholder =
        '--- Valor requerido ---'
      document.getElementById('porciento').focus()
      return false
    }
    if (document.getElementById('datos_registro').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('datos_registro').className =
        'form-control border border-danger'
      document.getElementById('datos_registro').placeholder =
        '--- Valor requerido ---'
      document.getElementById('datos_registro').focus()
      return false
    }
    if (document.getElementById('operaciones').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('operaciones').className =
        'form-control border border-danger'
      document.getElementById('operaciones').placeholder =
        '--- Valor requerido ---'
      document.getElementById('operaciones').focus()
      return false
    }
    if (document.getElementById('transportista').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('transportista').className =
        'form-control border border-danger'
      document.getElementById('transportista').placeholder =
        '--- Valor requerido ---'
      document.getElementById('transportista').focus()
      return false
    }
    if (document.getElementById('persona_transportador').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('persona_transportador').className =
        'form-control border border-danger'
      document.getElementById('persona_transportador').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_transportador').focus()
      return false
    }
    if (
      document.getElementById('fecha_recepcion_transportador').value.length == 0
    ) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('fecha_recepcion_transportador').className =
        'form-control border border-danger'
      document.getElementById('fecha_recepcion_transportador').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_recepcion_transportador').focus()
      return false
    }
    if (document.getElementById('persona_entrega').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('persona_entrega').className =
        'form-control border border-danger'
      document.getElementById('persona_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_entrega').focus()
      return false
    }
    if (document.getElementById('fecha_entrega').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('fecha_entrega').className =
        'form-control border border-danger'
      document.getElementById('fecha_entrega').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_entrega').focus()
      return false
    }
    if (document.getElementById('persona_recibe').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('persona_recibe').className =
        'form-control border border-danger'
      document.getElementById('persona_recibe').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_recibe').focus()
      return false
    }
    if (document.getElementById('fecha_recepcion').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('fecha_recepcion').className =
        'form-control border border-danger'
      document.getElementById('fecha_recepcion').placeholder =
        '--- Valor requerido ---'
      document.getElementById('fecha_recepcion').focus()
      return false
    }
    if (document.getElementById('persona_contabiliza').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('persona_contabiliza').className =
        'form-control border border-danger'
      document.getElementById('persona_contabiliza').placeholder =
        '--- Valor requerido ---'
      document.getElementById('persona_contabiliza').focus()
      return false
    }
    if (document.getElementById('importe_total').value.length == 0) {
      alert('Debe completar todos los datos de la Factura')
      document.getElementById('importe_total').className =
        'form-control border border-danger'
      document.getElementById('importe_total').placeholder =
        '--- Valor requerido ---'
      document.getElementById('importe_total').focus()
      return false
    }
    if (isNaN(document.getElementById('importe_total').value)) {
      alert('El valor debe ser un número')
      document.getElementById('importe_total').className =
        'form-control border border-danger'
      document.getElementById('importe_total').placeholder =
        '--- Valor requerido ---'
      document.getElementById('importe_total').focus()
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
      alert('Debe completar todos los datos de la Factura')
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
      fecha_modelo: document.getElementById('fecha_modelo').value,
      nro_factura: document.getElementById('nro_factura').value,
      entidad_id: document.getElementById('entidad').value,
      moneda_pago: document.getElementById('moneda_pago').value,
      porciento: document.getElementById('porciento').value,
      datos_registro: document.getElementById('datos_registro').value,
      operaciones: document.getElementById('operaciones').value,
      transportista: document.getElementById('transportista').value,
      persona_transportador: document.getElementById('persona_transportador')
        .value,
      fecha_recepcion_transportador: document.getElementById(
        'fecha_recepcion_transportador',
      ).value,
      persona_entrega: document.getElementById('persona_entrega').value,
      fecha_entrega: document.getElementById('fecha_entrega').value,
      persona_recibe: document.getElementById('persona_recibe').value,
      fecha_recepcion: document.getElementById('fecha_recepcion').value,
      persona_contabiliza: document.getElementById('persona_contabiliza').value,
      importe_total: document.getElementById('importe_total').value,

      productos: this.getProductos(),
    }

    $.ajax({
      url: `/facturas`,
      type: 'POST',
      dataType: 'json',
      data: data,
      context: this,
      success: function (response) {
        alert('Factura generada correctamente')
        window.open(`/facturas`, '_self')
      },
      error: function (error) {
        console.log('Fetching data: ERROR')
        console.log(JSON.stringify(error))
        alert(JSON.stringify(error))
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
