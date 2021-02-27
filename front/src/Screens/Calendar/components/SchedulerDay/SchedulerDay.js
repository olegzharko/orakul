/* eslint-disable react/prop-types */
import React from 'react';
import './SchedulerDay.scss';
import { getCorrectDate } from '../../utilits/functions';

const days = ['Нд', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];

const SchedulerDay = ({ day, hours }) => (
  <div className="scheduler__weekDay">
    <div className="scheduler__day">
      <p>{`${days[day]}(${getCorrectDate(day)})`}</p>
    </div>
    <div className="scheduler__timeLine">
      {hours.map((item) => (
        <p key={item}>{item}</p>
      ))}
    </div>
  </div>
);

export default SchedulerDay;
