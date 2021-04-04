import React from 'react';
import Templates from './components/Templates';
import ExchangeRate from './components/ExchangeRate';
import General from './components/General';
import Ownership from './components/Ownership';
import Rating from './components/Rating';
import SecurityPayment from './components/SecurityPayment';
import SellerBan from './components/SellerBan';

const ImmovableFields = () => (
  <div className="immovable__fields">
    <General />
    <ExchangeRate />
    <SellerBan />
    <Ownership />
    <SecurityPayment />
    <Rating />
    <Templates />
  </div>
);

export default ImmovableFields;
