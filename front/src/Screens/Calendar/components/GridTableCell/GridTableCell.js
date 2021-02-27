/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
/* eslint-disable react/prop-types */
import React from 'react';
import { useDispatch } from 'react-redux';
import { v4 as uuidv4 } from 'uuid';

// redux
import { setCurrentAppointment } from '../../../../store/actions';

export default function GridLayoutCell({ row, cell }) {
  const dispatch = useDispatch();
  // const layouts = useSelector(state => state.layouts);

  const handleClick = () => {
    const appointment = {
      i: uuidv4(),
      x: cell,
      y: row,
      w: 1,
      h: 1,
    };
    dispatch(setCurrentAppointment(appointment));
  };

  return <td onClick={handleClick} />;
}
