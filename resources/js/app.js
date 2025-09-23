import './bootstrap';
import "flyonui/flyonui"
import './main.js';


import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
});

window.notyf = notyf;