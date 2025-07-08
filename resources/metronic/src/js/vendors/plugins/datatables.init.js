"use strict";

//
// Datatables.net Initialization
//

// Set Defaults

const dtDefaults = {
  renderer: 'bootstrap',
  pagingType: 'simple_numbers',
  // dom:
  //   "<'table-responsive'tr>" +
  //   "<'row'" +
  //   "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start dt-toolbar'li>" +
  //   "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
  //   ">",
  lengthMenu: [{label: 'Semua', value: -1}, 10, 25, 50, 100],
  pageLength: 25,
  layout: {
    topStart: null,
    topEnd: 'search',
    bottomStart: ['pageLength', 'info'],
    bottomEnd: 'paging'
  },
  language: {
    zeroRecords: "Tidak ditemukan data yang sesuai",
    info: "_START_ s/d _END_ dari _TOTAL_",
    // infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
    infoFiltered: "",
    search: "Cari:",
    paginate: {
      first: '<i class="ki-duotone ki-double-left"><span class="path1"></span><span class="path2"></span></i>',
      last: '<i class="ki-duotone ki-double-right"><span class="path1"></span><span class="path2"></span></i>',
      next: '<i class="ki-duotone ki-right"></i>',
      previous: '<i class="ki-duotone ki-left"></i>'
    },
    autoFill: {
      cancel: "Batalkan",
      fill: 'Isi semua sel dengan <i>%d<i></i></i>',
      fillHorizontal: "isi sel secara horizontal",
      fillVertical: "isi sel secara vertikal"
    },
    buttons: {
      collection: 'Koleksi <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-s"></span>',
      colvis: "Visibilitas kolom",
      colvisRestore: "Kembalikan visibilitas",
      copy: "Salin",
      copyKeys: "Tekan ctrl atau u2318 + C untuk menyalin tabel data ke papan klip sistem",
      copyTitle: "Salin ke Papan Klip",
      copySuccess: {
        "1": "1 row berhasil disalin",
        "_": "%d row berhasil disalin ke papan klip"
      },
      csv: "CSV",
      excel: "Excel",
      pageLength: {
        "-1": "Tampilkan semua baris",
        "_": "Tampilkan %d baris"
      },
      pdf: "PDF",
      print: "Cetak"
    },
    decimal: ",",
    emptyTable: "Tidak ada data di tabel",
    infoEmpty: "Menampilkan 0 baris",
    // infoPostFix: "Menampilkan _START_ sampai _END_ dari _TOTAL_",
    infoThousands: ".",
    lengthMenu: "_MENU_",
    loadingRecords: "Memuat . . .",
    processing: '<span class="spinner-border w-15px h-15px text-muted align-middle me-2"></span><span class="text-gray-600">Sedang memproses...</span>',
    thousands: ".",
    aria: {
      sortAscending: "Urutkan Naik",
      sortDescending: "Urutkan Turun"
    },
    searchBuilder: {
      add: "Tambah Kondisi",
      clearAll: "Hapus Semua",
      condition: "Kondisi",
      data: "Data"
    },
    searchPlaceholder: "Ketik disini",
    datetime: {
      hours: "Jam",
      minutes: "Menit",
      seconds: "Detik",
      weekdays: {
        "1": "Sen",
        "2": "Sel",
        "3": "Rab",
        "4": "Kam",
        "5": "Jum",
        "6": "Sab",
        "0": "Min"
      },
      months: [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
      ],
      previous: "Kembali",
      next: "Lanjut",
      unknown: "-"
    },
    editor: {
      close: "Tutup",
      create: {
        button: "Baru",
        title: "Buat baris baru",
        submit: "Kirim"
      },
      edit: {
        button: "Ubah",
        title: "Ubah baris",
        submit: "Kirim"
      },
      remove: {
        button: "Hapus",
        title: "Hapus",
        submit: "Kirim",
        confirm: {
          "_": "Kamu mau hapus %d baris?",
          "1": "Kamu mau hapus 1 baris?"
        }
      },
      error: {
        system: 'Kesalahan sistem terdeteksi (<a rel="nofollow" href="">Informasi Selengkapnya</a>)'
      },
      multi: {
        title: "Beberapa nilai",
        info: "Item yang dipilih mengandung nilai yang berbeda untuk masukkan ini. Untuk mengubah dan mengaturnya semua item untuk masukkan ini untuk nilai yang sama, klik atau sentuh disini, jika tidak, mereka akan mempertahankan nilai-nilai individual mereka.",
        restore: "Batalkan Perubahan",
        noMulti: "Mauskkan ini tidak dapat diubah sendirian, tetapi bukan bagian di grup ini."
      }
    }
  },
};

// $.extend(true, $.fn.dataTable.defaults, defaults);

/*! DataTables Bootstrap 5 integration
 * © SpryMedia Ltd - datatables.net/license
 */

(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD
    define(['jquery', 'datatables.net'], function ($) {
      return factory($, window, document);
    });
  } else if (typeof exports === 'object') {
    // CommonJS
    var jq = require('jquery');
    var cjsRequires = function (root, $) {
      if (!$.fn.dataTable) {
        require('datatables.net')(root, $);
      }
    };

    if (typeof window === 'undefined') {
      module.exports = function (root, $) {
        if (!root) {
          // CommonJS environments without a window global must pass a
          // root. This will give an error otherwise
          root = window;
        }

        if (!$) {
          $ = jq(root);
        }

        cjsRequires(root, $);
        return factory($, root, root.document);
      };
    } else {
      cjsRequires(window, jq);
      module.exports = factory(jq, window, window.document);
    }
  } else {
    // Browser
    factory(jQuery, window, document);
  }
}(function ($, window, document) {
  'use strict';
  let DataTable = $.fn.dataTable;

  /**
   * DataTables integration for Bootstrap 5.
   *
   * This file sets the defaults and adds options to DataTables to style its
   * controls using Bootstrap. See https://datatables.net/manual/styling/bootstrap
   * for further information.
   */

  /* Set the defaults for DataTables initialisation */
  $.extend(true, DataTable.defaults, dtDefaults, {
    dom: 'lfrtip',
    rowGroup: {
        dataSrc: 'group'
    }
  });


  /* Default class modification */
  $.extend(true, DataTable.ext.classes, {
    container: "dt-container dt-bootstrap5",
    search: {
      input: "form-control form-control-solid form-control-sm"
    },
    length: {
      select: "form-select form-select-solid form-select-sm"
    },
    processing: {
      container: "dt-processing"
    },
    layout: {
      row: 'row mt-2 justify-content-between',
      cell: 'd-md-flex justify-content-between align-items-center',
      tableCell: 'col-12',
      start: 'dt-layout-start col-md-auto me-auto',
      end: 'dt-layout-end col-md-auto ms-auto',
      full: 'dt-layout-full col-md'
    }
  });


  /* Bootstrap paging button renderer */
  DataTable.ext.renderer.pagingButton.bootstrap = function (settings, buttonType, content, active, disabled) {
    let btnClasses = ['dt-paging-button', 'page-item'];

    if (active) {
      btnClasses.push('active');
    }

    if (disabled) {
      btnClasses.push('disabled')
    }

    let li = $('<li>').addClass(btnClasses.join(' '));
    let a = $('<button>', {
      'class': 'page-link',
      role: 'link',
      type: 'button'
    })
      .html(content)
      .appendTo(li);

    return {
      display: li,
      clicker: a
    };
  };

  DataTable.ext.renderer.pagingContainer.bootstrap = function (settings, buttonEls) {
    return $('<ul/>').addClass('pagination').append(buttonEls);
  };

  // DataTable.ext.renderer.layout.bootstrap = function ( settings, container, items ) {
  // 	var row = $( '<div/>', {
  // 			"class": items.full ?
  // 				'row mt-2 justify-content-md-center' :
  // 				'row mt-2 justify-content-between'
  // 		} )
  // 		.appendTo( container );

  // 	$.each( items, function (key, val) {
  // 		var klass;
  // 		var cellClass = '';

  // 		// Apply start / end (left / right when ltr) margins
  // 		if (val.table) {
  // 			klass = 'col-12';
  // 		}
  // 		else if (key === 'start') {
  // 			klass = '' + cellClass;
  // 		}
  // 		else if (key === 'end') {
  // 			klass = '' + cellClass;
  // 		}
  // 		else {
  // 			klass = ' ' + cellClass;
  // 		}

  // 		$( '<div/>', {
  // 				id: val.id || null,
  // 				"class": klass + ' ' + (val.className || '')
  // 			} )
  // 			.append( val.contents )
  // 			.appendTo( row );
  // 	} );
  // };

  DataTable.ext.renderer.layout.bootstrap = function ( settings, container, items ) {
    let classes = settings.oClasses.layout;
    let row = $('<div/>')
      .attr('id', items.id || null)
      .addClass(items.className || classes.row)
      .appendTo( container );

    $.each( items, function (key, val) {
      if (key === 'id' || key === 'className') {
        return;
      }

      let klass = '';
      let content = val.contents;

      if (val.table) {
        row.addClass(classes.tableRow);
        klass += classes.tableCell + ' ';
        content = $('<div/>').attr('class', 'table-responsive').append(content);
      }

      if (key === 'start') {
        klass += classes.start;
      }
      else if (key === 'end') {
        klass += classes.end;
      }
      else {
        klass += classes.full;
      }

      $('<div/>')
        .attr({
          id: val.id || null,
          "class": val.className
            ? val.className
            : classes.cell + ' ' + klass
        })
        .append( content )
        .appendTo( row );
    } );
  };

  return DataTable;
}));
