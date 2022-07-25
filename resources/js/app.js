require('./bootstrap');
require('alpinejs');

import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

window.FilePond = FilePond;
window.FilePondPluginImagePreview = FilePondPluginImagePreview;

import ApexCharts from 'apexcharts'
window.ApexCharts = ApexCharts;

require('./practice-form');
require('./progress-bar');