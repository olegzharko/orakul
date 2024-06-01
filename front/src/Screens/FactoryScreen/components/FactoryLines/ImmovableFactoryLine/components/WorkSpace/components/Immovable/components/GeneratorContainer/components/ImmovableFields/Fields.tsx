import React from 'react';

import General from './components/General';
import Ownership from './components/Ownership';
import SecurityPayment from './components/SecurityPayment';
import Installment from './components/Installment';
import Rating from './components/Rating';
import Termination from './components/Termination';
import Templates from './components/Templates';
import { useFields } from './useFields';

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
