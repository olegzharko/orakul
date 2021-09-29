import React from 'react';
import Header from '../../components/Header';

import BankCardsDashboard from '../../components/BankCardsDashboard';

import './index.scss';

const BankUserScreen = () => (
  <>
    <Header />
    <div className="bank-container">
      <BankCardsDashboard />
    </div>
  </>
);

export default BankUserScreen;
