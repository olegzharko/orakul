import React from 'react';

import PrimaryButton from '../../../../../../components/PrimaryButton';
import SecondaryButton from '../../../../../../components/SecondaryButton';

import '../../../../index.scss';
import { formatClientTime } from '../../utils';
import WaitingRoomCardContent from '../WaitingRoomCardContent';
import { useWaitingRoomClientCard, WaitingRoomCardProps } from './useWaitingRoomClientCard';

const WaitingRoomCard = (props: WaitingRoomCardProps) => {
  const {
    title,
    client,
    isNotary,
    representativeTitleColor,
    handleMoreClick,
    handleToReceptionClick,
    handleFinishClick,
    handleToNotaryClick,
  } = useWaitingRoomClientCard(props);

  return (
    <div className="room-card">
      <div className="room-card__header" style={{ backgroundColor: client.color }}>
        <span className="room-card__header-title">{title}</span>
        <button
          onClick={handleMoreClick}
          className="room-card__header-button"
          type="button"
        >
          Переглянути
        </button>
      </div>
      <div className="room-card__body">
        <div className="main-info">
          <span>
            <img src="/images/clock.svg" alt="clock" />
            Початок:
            <b>
              {formatClientTime(client.start_time)}
            </b>
          </span>
          <span>
            <img src="/images/clock.svg" alt="clock" />
            Загальний час:
            <b>
              {formatClientTime(client.total_time)}
            </b>
          </span>
          <span>
            <img src="/images/user.svg" alt="clock" />
            Кількість клієнтів:
            <b>
              {client.number_of_people}
            </b>
          </span>
          <span>
            <img src="/images/user.svg" alt="user" />
            Підписант:
            <span style={{ color: representativeTitleColor.color }}>
              {representativeTitleColor.title}
            </span>
          </span>
        </div>

        <div className="immovables">
          <WaitingRoomCardContent
            title="Нерухомість:"
            icon="/images/navigation/immovable.svg"
            info={(client.immovable || []).map(({ title, step }) => `${title} - ${step}`)}
          />
        </div>

        <div className="client">
          <WaitingRoomCardContent
            title="Покупеуць:"
            icon="/images/user.svg"
            info={(client.buyer || []).map(({ title }) => title)}
          />
        </div>

        <hr />

        <div className="additional">
          <div className="additional__item">
            <WaitingRoomCardContent
              title="Нотаріус:"
              icon="/images/user.svg"
              info={(client.notary || []).map(({ title }) => title)}
            />
          </div>

          <div className="additional__item">
            <WaitingRoomCardContent
              title="Читач:"
              icon="/images/user.svg"
              info={(client.reader || []).map(({ title }) => title)}
            />
          </div>

          <div className="additional__item">
            <WaitingRoomCardContent
              title="Видавач:"
              icon="/images/user.svg"
              info={(client.accompanying || []).map(({ title }) => title)}
            />
          </div>

          <div className="additional__item">
            <WaitingRoomCardContent
              title="Підписант:"
              icon="/images/user.svg"
              info={(client.representative || []).map(({ title }) => title)}
            />
          </div>
        </div>

        <div className="room-card__buttons">
          <PrimaryButton
            label="До приймальні"
            onClick={handleToReceptionClick}
          />
          <SecondaryButton
            label="Завершити послугу"
            onClick={handleFinishClick}
            disabled={false}
          />
          {!isNotary && (
            <SecondaryButton
              label="До нотаріуса"
              onClick={handleToNotaryClick}
              disabled={false}
            />
          )}
        </div>
      </div>
    </div>
  );
};

export default WaitingRoomCard;
