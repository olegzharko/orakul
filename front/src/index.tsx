import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter as Router } from 'react-router-dom';

import App from './App';
import store from './store';
import ScrollToTop from './Hooks/ScrollToTop';

ReactDOM.render(
  <React.StrictMode>
    <Router>
      <Provider store={store}>
        <ScrollToTop />
        <App />
      </Provider>
    </Router>
  </React.StrictMode>,
  document.getElementById('root')
);
