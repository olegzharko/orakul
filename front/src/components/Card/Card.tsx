import * as React from 'react';
import './index.scss';
import { Link } from 'react-router-dom';
import ReactHtmlParser from 'react-html-parser';

type Props = {
  title: string;
  children: React.ReactNode;
  link: string
  disabled?: boolean;
  headerColor?: string;
  haveStatus?: boolean;
}

const Card = ({ title, headerColor, children, link, haveStatus, disabled }: Props) => {
  const getTextColor = () => {
    if (haveStatus) return 'black';
    if (headerColor) return 'white';

    return '';
  };

  const getTitleBackgroundColor = () => {
    if (haveStatus) return '';
    if (headerColor) return headerColor;

    return '';
  };

  if (disabled) {
    return (
      <div className="card disabled">
        <div className="card__header" style={{ backgroundColor: getTitleBackgroundColor() }}>
          <span style={{ color: getTextColor() }}>{ReactHtmlParser(title)}</span>
          {haveStatus && (
          <div className="status" style={{ backgroundColor: headerColor || '' }} />
          )}
        </div>
        <div className="card__main">
          {children}
        </div>
      </div>
    );
  }

  return (
    <Link to={link} className="card">
      <div className="card__header" style={{ backgroundColor: getTitleBackgroundColor() }}>
        <span style={{ color: getTextColor() }}>{ReactHtmlParser(title)}</span>
        {haveStatus && (
          <div className="status" style={{ backgroundColor: headerColor || '' }} />
        )}
      </div>
      <div className="card__main">
        {children}
      </div>
    </Link>
  );
};

export default Card;
