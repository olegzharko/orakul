import React from 'react';
import Dashboard from '../../../../../../components/Dashboard';

const dashboardData = [
  {
    title: 'Понеділок 15.02',
    cards: [
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: 'red'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: 'grey'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: 'blue'
      },
    ]
  },
  {
    title: 'Понеділок 15.02',
    cards: [
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
    ]
  },
  {
    title: 'Понеділок 15.02',
    cards: [
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: 'grey'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
    ]
  },
  {
    title: 'Понеділок 15.02',
    cards: [
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: 'blue'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
    ]
  },
  {
    title: 'Понеділок 15.02',
    cards: [
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: 'red'
      },
      {
        id: 1,
        title: 'Боголюбова 44 кв 77',
        content: ['Передано у набір'],
        color: '#04BC00'
      },
    ]
  },
];

const AssistantInfoOtherActionsPage = () => (
  <div className="assistant-info-otherActionsPage">
    <Dashboard
      isChangeTypeButton
      sections={dashboardData}
    />
  </div>
);

export default AssistantInfoOtherActionsPage;
