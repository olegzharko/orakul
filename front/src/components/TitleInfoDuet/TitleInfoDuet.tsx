import * as React from 'react';
import './index.scss';

type Props = {
  title: string;
  info: string;
}

const TitleInfoDuet = ({ title, info }: Props) => (
  <div className="title-info-duet">
    <span className="title">{title}</span>
    <span className="info">{info}</span>
  </div>
);

export default TitleInfoDuet;
