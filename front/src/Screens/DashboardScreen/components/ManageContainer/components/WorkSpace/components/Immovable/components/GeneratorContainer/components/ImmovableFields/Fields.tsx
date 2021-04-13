import React from 'react';
import Templates from './components/Templates';
import ExchangeRate from './components/ExchangeRate';
import General from './components/General';
import Ownership from './components/Ownership';
import Rating from './components/Rating';
import SecurityPayment from './components/SecurityPayment';
import SellerBan from './components/SellerBan';
import { useFields } from './useFields';

const Fields = () => {
  const meta = useFields();

  return (
    <div className="immovable__fields">
      <General initialData={meta.general} id={meta.immovableId} />
      <ExchangeRate initialData={meta.exchange} id={meta.immovableId} />
      <SellerBan initialData={meta.sellerBan} id={meta.immovableId} />
      <Ownership initialData={meta.ownerShip} id={meta.immovableId} />
      <SecurityPayment initialData={meta.securityPayment} id={meta.immovableId} />
      <Rating initialData={meta.rating} id={meta.immovableId} />
      <Templates initialData={meta.templates} id={meta.immovableId} />
    </div>
  );
};

export default Fields;
