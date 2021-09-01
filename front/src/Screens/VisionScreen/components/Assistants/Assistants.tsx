import React from 'react';

import './index.scss';
import AssistantsRoomSection from './components/AssistantsRoomSection';

const employees = [
  {
    name: 'Кравченко Анастасія',
    startTime: '08:45',
    set: '14/15',
    reading: '12/20',
    issuance: '19/19',
    color: 'red'
  },
  {
    name: 'Кравченко Анастасія',
    startTime: '08:45',
    set: '14/15',
    reading: '12/20',
    issuance: '19/19',
    color: 'grey'
  },
  {
    name: 'Кравченко Анастасія',
    startTime: '08:45',
    set: '14/15',
    reading: '12/20',
    issuance: '19/19',
    color: 'green'
  },
  {
    name: 'Кравченко Анастасія',
    startTime: '08:45',
    set: '14/15',
    reading: '12/20',
    issuance: '19/19',
    color: 'blue'
  },
  {
    name: 'Кравченко Анастасія',
    startTime: '08:45',
    set: '14/15',
    reading: '12/20',
    issuance: '19/19',
    color: 'red'
  },
];

const Assistants = () => (
  <div className="vision-assistants">
    <AssistantsRoomSection title="Open Space" employees={employees} />
    <AssistantsRoomSection title="Data Room" employees={employees} />
    <AssistantsRoomSection title="Приймальня" employees={employees} />
    <AssistantsRoomSection title="Рецепція" employees={employees} />
  </div>
);

export default Assistants;
