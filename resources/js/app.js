import './bootstrap';
import "datatables.net-dt/css/dataTables.dataTables.css";
import 'datatables.net-dt/js/dataTables.dataTables';
import Alpine from 'alpinejs';
import $ from 'jquery';
import 'datatables.net-dt';
import { golonganPramuka } from './golongan.js';


window.Alpine = Alpine;
Alpine.start();
window.$ = $;
window.jQuery = $;
window.golonganPramuka = golonganPramuka;



