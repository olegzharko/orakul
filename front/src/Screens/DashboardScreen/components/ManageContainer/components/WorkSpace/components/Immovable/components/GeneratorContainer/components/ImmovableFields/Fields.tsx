import React from 'react';
import Templates from './components/Templates';
import General from './components/General';
import Ownership from './components/Ownership';
import Rating from './components/Rating';
import SecurityPayment from './components/SecurityPayment';
import { useFields } from './useFields';
import Termination from './components/Termination';
import Installment from './components/Installment';

const Fields = () => {
  const meta = useFields();

  return (
    <div className="immovable__fields">
      <General initialData={meta.general} id={meta.immovableId} />
      <Ownership initialData={meta.ownerShip} id={meta.immovableId} />
      <SecurityPayment initialData={meta.securityPayment} id={meta.immovableId} />
      <Installment initialData={meta.installment} id={meta.immovableId} />
      <Rating initialData={meta.retting} id={meta.immovableId} />
      <Termination initialData={meta.termination} id={meta.immovableId} />
      <Templates initialData={meta.templates} id={meta.immovableId} />
    </div>
  );
};

export default Fields;
