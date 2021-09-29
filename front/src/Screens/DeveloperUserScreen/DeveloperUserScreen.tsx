import React from 'react';

import Header from '../../components/Header';
import Loader from '../../components/Loader/Loader';

import './index.scss';
import { useDeveloperUserScreen } from './useDeveloperUserScreen';

const DeveloperUserScreen = () => {
  const {
    isLoading,
    sectionsCards,
  } = useDeveloperUserScreen();

  if (isLoading) return <Loader />;

  return (
    <div className="developer">
      <Header />

      {sectionsCards.length === 0 ? (
        <div className="developer__nodata">
          <img src="/images/nodata.png" alt="no-data" />
        </div>
      ) : (
        <div className="developer__body">
          <div className="developer__dashboard">
            {sectionsCards.map(({ day, date, cards }) => (
              <div className="section" key={date}>
                <div className="section__header">
                  <span className="title">
                    {day}
                    {' '}
                    {date}
                  </span>
                </div>
                <div className="section__body grid">
                  {cards.map(({ id, immovables, clients, time }) => (
                    <div className="card" key={id}>
                      <div className="card__title">
                        <img src="/images/clock.svg" alt="clock" />
                        <span>{time}</span>
                      </div>
                      <div className="info-block">
                        {immovables.map((val) => (
                          <span key={val}>{val}</span>
                        ))}
                      </div>
                      <div className="info-block">
                        {clients.map((val) => (
                          <span key={val}>{val}</span>
                        ))}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
};

export default DeveloperUserScreen;
