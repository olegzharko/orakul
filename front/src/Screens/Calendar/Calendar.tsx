import React, { useState, useEffect } from 'react';
import './index.scss';
import { useDispatch } from 'react-redux';
import { v4 as uuidv4 } from 'uuid';
import { getHours } from './utilits/functions';
import { data } from './data';

// components
import SchedulerDay from './components/SchedulerDay/SchedulerDay';
import GridLayout from './components/GridLayout/GridLayout';
import GridTable from './components/GridTable/GridTable';

// redux
import { setLayouts } from '../../store/actions';

const rooms = [1, 2, 3, 4, 5, 6];

const days = [1, 2, 3, 4, 5, 6];

const Calendar = () => {
  const [hours] = useState(getHours(10, 18));
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(setLayouts(data.map((prop) => ({ ...prop, w: 1, h: 1 }))));
  }, []);

  return (
    <div className="scheduler">
      <div className="scheduler__header">
        <div />
        <div>
          <table>
            <tbody>
              <tr>
                {rooms.map((item) => (
                  <td key={item}>{item}</td>
                ))}
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div className="scheduler__body">
        <div className="scheduler__dayBar">
          {days.map((item) => (
            <SchedulerDay day={item} hours={hours} key={uuidv4()} />
          ))}
        </div>
        <div className="scheduler__appointments">
          <GridTable days={days} hours={hours} />
          <GridLayout />
        </div>
      </div>
    </div>
  );
};

export default Calendar;
