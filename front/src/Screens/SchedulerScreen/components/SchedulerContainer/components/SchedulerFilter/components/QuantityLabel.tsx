import React from 'react';
import { useSelector } from 'react-redux';
import { State } from '../../../../../../../store/types';

export const QuantityLabel = () => {
  const { appointments } = useSelector((state: State) => state.scheduler);

  return (
    <span style={{ whiteSpace: 'nowrap' }}>
      {`В роботі: ${appointments?.length}`}
    </span>
  );
};

export default QuantityLabel;
