import React from 'react';
import ContentPanel from '../../../../../../components/ContentPanel';
import Dashboard from '../../../../../../components/Dashboard';

import Filter from '../../../../../DashboardScreen/components/DashboardContainer/components/FilterContainer';

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
        color: '#04BC00'
      },
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
        color: '#04BC00'
      },
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
        color: '#04BC00'
      },
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
        color: '#04BC00'
      },
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
];

const AssistantInfoSetPage = () => (
  <div className="assistant-info-setPage">
    <Filter />
    <div className="set-page__dashboard">
      <Dashboard
        isChangeTypeButton
        sections={dashboardData}
      />
    </div>
  </div>
);

export default AssistantInfoSetPage;
