/* eslint-disable react/jsx-one-expression-per-line */
import React from 'react';
import { Link } from 'react-router-dom';

import PrimaryButton from '../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../components/SecondaryButton';

import '../../../../index.scss';
import WaitingRoomCardContent from '../WaitingRoomCardContent';

type WaitingRoomCardProps = {
  title: string;
  headerButtonTitle: string;
  headerButtonLink: string;
}

const WaitingRoomCard = ({ title, headerButtonTitle, headerButtonLink }: WaitingRoomCardProps) => (
  <div className="room-card">
    <div className="room-card__header">
      <span className="room-card__header-title">{title}</span>
      <Link
        to={headerButtonLink}
        className="room-card__header-button"
      >
        {headerButtonTitle}
      </Link>
    </div>
    <div className="room-card__body">
      <div className="main-info">
        <span>
          <img src="/images/clock.svg" alt="clock" />
          Початок:
          <b>13:05</b>
        </span>
        <span>
          <img src="/images/clock.svg" alt="clock" />
          Загальний час:
          <b>00:58</b>
        </span>
        <span>
          <img src="/images/user.svg" alt="clock" />
          Кількість клієнтів:
          <b>2</b>
        </span>
        <span>
          <img src="/images/user.svg" alt="user" />
          Підписант: <span style={{ color: '#FF3400' }}>Очікує запрошення</span>
        </span>
        <span>
          <img src="/images/file.svg" alt="file" />
          Етап: <b>Ознайомлюються з договором</b>
        </span>
      </div>

      <div className="immovables">
        <WaitingRoomCardContent
          title="Нерухомість:"
          icon="/images/navigation/immovable.svg"
          info={[
            'вул. Ломоносова 40, кв. 101',
            'вул. Соборна 21, кв. 88',
          ]}
        />
      </div>

      <div className="client">
        <WaitingRoomCardContent
          title="Покупеуць:"
          icon="/images/user.svg"
          info={[
            'Жарко Олег Володимирович',
            'Конієко Володимир Олександрович',
          ]}
        />
      </div>

      <hr />

      <div className="additional">
        <div className="additional__item">
          <WaitingRoomCardContent
            title="Нотаріус:"
            icon="/images/user.svg"
            info={['Петрова Світлана Миколаївна']}
          />
        </div>

        <div className="additional__item">
          <WaitingRoomCardContent
            title="Читач:"
            icon="/images/user.svg"
            info={[
              'Коберник Ігор',
              'Корпенко Святослав',
            ]}
          />
        </div>

        <div className="additional__item">
          <WaitingRoomCardContent
            title="Видавач:"
            icon="/images/user.svg"
            info={['Самойленко Максим']}
          />
        </div>

        <div className="additional__item">
          <WaitingRoomCardContent
            title="Підписант:"
            icon="/images/user.svg"
            info={['Боярчув Вікторія Валеріївна']}
          />
        </div>
      </div>

      <div className="room-card__buttons">
        <PrimaryButton
          label="До приймальні"
          onClick={() => console.log('click')}
        />
        <SecondaryButton
          label="Завершити послугу"
          onClick={() => console.log('click')}
          disabled={false}
        />
        <SecondaryButton
          label="До нотаріуса"
          onClick={() => console.log('click')}
          disabled={false}
        />
      </div>
    </div>
  </div>
);

export default WaitingRoomCard;
